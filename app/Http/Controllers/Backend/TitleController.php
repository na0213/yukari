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
use App\Models\Title;

class TitleController extends Controller
{
    public function index(Region $region)
    {
        $titles = $region->titles()->get();
        return view('backend.titles.index', compact('titles','region'));
    }

    public function create(Region $region)
    {
        $admin = Admin::find(Auth::guard('admins')->id());
        return view('backend.titles.create', compact('admin', 'region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required|integer|exists:regions,id',
            'title_name' => 'required|string|max:255',
            'total_point' => 'required|integer|min:0',
            'image' => 'required|image|max:3072', // 3MBまでの画像
        ]);

        try {
            DB::beginTransaction();
        
            $url = null;
            if ($request->hasFile('image')) {
                // 画像ファイルを取得
                $file = $request->file('image');
                // ファイル名の生成（ユニークなIDを利用）
                $fileName = 'images/' . uniqid() . '.' . $file->getClientOriginalExtension();
                // S3にアップロード
                Storage::disk('s3')->put($fileName, file_get_contents($file), 'public');
                // アップロードされた画像のURLを取得
                $url = Storage::disk('s3')->url($fileName);
            }
        
            $title = new Title;
            $title->region_id = $request->input('region_id');
            $title->title_name = $request->input('title_name');
            $title->total_point = $request->input('total_point');
            $title->image = $url;
            $title->save();
        
            DB::commit();
            return redirect()->route('admin.backend.titles.index', ['region' => $request->input('region_id')])->with('success', '登録されました。');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => '保存に失敗しました。']);
        }
    }

    public function edit(Region $region, Title $title)
    {
        $admin = Admin::find(Auth::guard('admins')->id());
        return view('backend.titles.edit', compact('admin', 'region', 'title'));
    }

    public function update(Request $request, Region $region, Title $title)
    {
        $validated = $request->validate([
            'title_name' => 'required|string|max:255',
            'total_point' => 'required|integer|min:0',
            'image' => 'nullable|image|max:3072',
        ]);

        try {
            DB::beginTransaction();

            $title->title_name = $validated['title_name'];
            $title->total_point = $validated['total_point'];

            if ($request->hasFile('image')) {
                // 既存の画像をS3から削除
                if ($title->image) {
                    $existingImagePath = parse_url($title->image, PHP_URL_PATH);
                    Storage::disk('s3')->delete($existingImagePath);
                }

                // 新しい画像をアップロード
                $file = $request->file('image');
                $fileName = 'images/' . uniqid() . '.' . $file->getClientOriginalExtension();
                Storage::disk('s3')->put($fileName, file_get_contents($file), 'public');
                $url = Storage::disk('s3')->url($fileName);

                // データベースを更新
                $title->image = $url;
            }

            $title->save();

            DB::commit();

            return redirect()->route('admin.backend.titles.index', ['region' => $region->id])
                ->with('message', '情報が更新されました');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => '更新に失敗しました。']);
        }
    }

    public function destroy(Region $region, Title $title)
    {
        // S3から画像を削除
        if ($title->image) {
            Storage::disk('s3')->delete(parse_url($title->image, PHP_URL_PATH));
        }

        // データベースから削除
        $title->delete();

        return redirect()->route('admin.backend.titles.index', ['region' => $region->id])->with('success', '削除されました。');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'region_id' => 'required|integer|exists:regions,id',
    //         'title_name' => 'required|string|max:255',
    //         'total_point' => 'required|integer|min:0', // 数値としてバリデーション
    //         'image' => 'required|image|max:3072',
    //     ]);

    //     $manager = new ImageManager(new Driver());

    //     try {
    //         // トランザクション開始
    //         DB::beginTransaction();
    
    //         $url = null;
    //         if ($request->hasFile('image')) {
    //             // ファイルから画像を読み込み
    //             $image = $manager->read($request->file('image')->getPathName());
    
    //             // 画像を一時的なファイルとして保存
    //             $tempPath = tempnam(sys_get_temp_dir(), 'Image') . '.jpg';
    //             $image->toPng()->save($tempPath);
    
    //             // 保存した一時ファイルをS3にアップロード
    //             $fileName = 'images/' . uniqid() . '.jpg';
    //             Storage::disk('s3')->put($fileName, file_get_contents($tempPath), 'public');
    //             $url = Storage::disk('s3')->url($fileName);
    
    //             // 一時ファイルを削除
    //             @unlink($tempPath);
    //         }
    
    //         $title = new Title;
    //         $title->region_id = $request->input('region_id');
    //         $title->title_name = $request->input('title_name');
    //         $title->total_point = $request->input('total_point');
    //         $title->image = $url;
    //         $title->save();
    
    //         // トランザクションコミット
    //         DB::commit();
    //         return redirect()->route('admin.backend.titles.index', ['region' => $request->input('region_id')])->with('success', '登録されました。');
    //     } catch (\Exception $e) {
    //         // エラーが発生した場合はロールバック
    //         DB::rollback();
    //         Log::error($e->getMessage());
    //         return back()->withInput()->withErrors(['error' => '保存に失敗しました。']);
    //     }
    // }
    // public function update(Request $request, Region $region, Title $title)
    // {
    //     $validated = $request->validate([
    //         'title_name' => 'required|string|max:255',
    //         'total_point' => 'required|integer|min:0',
    //         'image' => 'nullable|image|max:3072',
    //     ]);
    
    //     $manager = new ImageManager(new Driver());

    //     try {
    //         DB::beginTransaction();
    
    //         // $place = Place::findOrFail($id);
    //         $title->title_name = $validated['title_name'];
    //         $title->total_point = $validated['total_point'];

    //         if ($request->hasFile('image')) {
    //             // 既存の画像をS3から削除
    //             if ($title->image) {
    //                 $existingImagePath = parse_url($title->image, PHP_URL_PATH);
    //                 Storage::disk('s3')->delete($existingImagePath);
    //             }
    
    //             // 新しい画像を処理
    //             $image = $manager->read($request->file('image')->getPathName());
    //             $image->scale(width: 300);
    //             $tempPath = tempnam(sys_get_temp_dir(), 'Image') . '.jpg';
    //             $image->toPng()->save($tempPath);
    
    //             // S3にアップロード
    //             $fileName = 'images/' . uniqid() . '.jpg';
    //             Storage::disk('s3')->put($fileName, file_get_contents($tempPath), 'public');
    //             $url = Storage::disk('s3')->url($fileName);
    
    //             // 一時ファイルを削除
    //             @unlink($tempPath);
    
    //             // データベースを更新
    //             $title->image = $url;
    //         }

    //         $title->save();
    
    
    //         DB::commit();
    
    //         return redirect()->route('admin.backend.titles.index', ['region' => $region->id])
    //             ->with('message', '情報が更新されました');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Log::error($e->getMessage());
    //         return back()->withInput()->withErrors(['error' => '更新に失敗しました。']);
    //     }
    // }

}
