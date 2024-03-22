<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Region;

class RegionController extends Controller
{
    public function index()
    {
        $admin = Admin::find(Auth::guard('admins')->id());
        $regions = Region::all();

        return view('backend.regions.index', compact('admin', 'regions'));
    }

    public function create()
    {
        $admin = Admin::find(Auth::guard('admins')->id());
        $regions = Region::all();

        return view('backend.regions.create', compact('admin', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'info' => 'required|string|max:3000',
            'link' => 'required|string|max:255',
            'point' => 'required|integer|min:0', // 数値としてバリデーション
            'image' => 'required|image', // 1MBまで
        ]);

        $manager = new ImageManager(new Driver());

        try {
            // トランザクション開始
            DB::beginTransaction();
    
            $url = null;
            if ($request->hasFile('image')) {
                // ファイルから画像を読み込み
                $image = $manager->read($request->file('image')->getPathName());
    
                $image->scale(width: 1000);
    
                // 画像を一時的なファイルとして保存
                $tempPath = tempnam(sys_get_temp_dir(), 'regionImage') . '.jpg';
                $image->toPng()->save($tempPath);
    
                // 保存した一時ファイルをS3にアップロード
                $fileName = 'region_images/' . uniqid() . '.jpg';
                Storage::disk('s3')->put($fileName, file_get_contents($tempPath), 'public');
                $url = Storage::disk('s3')->url($fileName);
    
                // 一時ファイルを削除
                @unlink($tempPath);
            }
    
            // Animalインスタンスの作成と保存
            $region = new Region;
            $region->name = $request->input('name');
            $region->place = $request->input('place');
            $region->info = $request->input('info');
            $region->link = $request->input('link');
            $region->point = $request->input('point');
            $region->image = $url;
            $region->save();
    
            // トランザクションコミット
            DB::commit();
            return redirect()->route('admin.backend.rergions.create')->with('success', '登録されました。');
        } catch (\Exception $e) {
            // エラーが発生した場合はロールバック
            DB::rollback();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => '保存に失敗しました。']);
        }
    }

    public function edit(string $id)
    {
        $region = Region::findOrFail($id);
    
        return view('backend.regions.edit', compact('region'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'info' => 'required|string|max:3000',
            'link' => 'required|string|max:255',
            'point' => 'required|integer|min:0',
            'image' => 'nullable|image',
        ]);
    
        $manager = new ImageManager(new Driver());

        try {
            DB::beginTransaction();
    
            $region = Region::findOrFail($id);
            $region->name = $validated['name'];
            $region->place = $validated['place'];
            $region->info = $validated['info'];
            $region->link = $validated['link'];
            $region->point = $validated['point'];

            if ($request->hasFile('image')) {
                // 既存の画像をS3から削除
                if ($region->image) {
                    $existingImagePath = parse_url($region->image, PHP_URL_PATH);
                    Storage::disk('s3')->delete($existingImagePath);
                }
    
                // 新しい画像を処理
                $image = $manager->read($request->file('image')->getPathName());
                $image->scale(width: 300);
                $tempPath = tempnam(sys_get_temp_dir(), 'regionImage') . '.jpg';
                $image->toPng()->save($tempPath);
    
                // S3にアップロード
                $fileName = 'region_images/' . uniqid() . '.jpg';
                Storage::disk('s3')->put($fileName, file_get_contents($tempPath), 'public');
                $url = Storage::disk('s3')->url($fileName);
    
                // 一時ファイルを削除
                @unlink($tempPath);
    
                // データベースを更新
                $region->image = $url;
            }

            $region->save();
    
    
            DB::commit();
    
            return redirect()->route('admin.backend.regions.create', ['region' => $region->region->id])
                ->with('message', '情報が更新されました');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => '更新に失敗しました。']);
        }
    }

    public function destroy(string $id)
    {
        $region = Region::findOrFail($id);

        // S3から画像を削除
        if ($region->image) {
            Storage::disk('s3')->delete(parse_url($region->image, PHP_URL_PATH));
        }
    
        // データベースから削除
        $region->delete();
    
        return redirect()->route('admin.backend.regions.index')->with('success', '削除されました。');
    }
}
