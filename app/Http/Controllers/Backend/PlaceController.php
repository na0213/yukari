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
use App\Models\Place;
use Validator; 

class PlaceController extends Controller
{
    public function index(Region $region)
    {
        $places = $region->places()->get();
        return view('backend.places.index', compact('places','region'));
    }

    public function create(Region $region)
    {
        $admin = Admin::find(Auth::guard('admins')->id());
        return view('backend.places.create', compact('admin', 'region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required|integer|exists:regions,id',
            'place_name' => 'required|string|max:255',
            'place_info' => 'required|string|max:3000',
            'place_link' => 'required|string|max:255',
            'place_point' => 'required|integer|min:0',
            'place_image' => 'required|image|max:3072', // 3MBまでの画像
        ]);
        try {
            DB::beginTransaction();
            if ($request->hasFile('place_image')) {
                // 画像ファイルの取得
                $file = $request->file('place_image');
                // ファイル名の生成（ユニークなIDを利用）
                $fileName = 'place_images/' . uniqid() . '.' . $file->getClientOriginalExtension();
                // S3にアップロード
                $path = Storage::disk('s3')->put($fileName, file_get_contents($file), 'public');
                // アップロードされた画像のURLを取得
                $url = Storage::disk('s3')->url($fileName);
            }
            $place = new Place;
            $place->region_id = $request->input('region_id');
            $place->place_name = $request->input('place_name');
            $place->place_info = $request->input('place_info');
            $place->place_link = $request->input('place_link');
            $place->place_point = $request->input('place_point');
            $place->place_image = $url ?? null;
            $place->save();
            DB::commit();
            return redirect()->route('admin.backend.places.index', ['region' => $request->input('region_id')])->with('success', '登録されました。');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => '保存に失敗しました。']);
        }
    }

    public function edit(Region $region, Place $place)
    {
        $admin = Admin::find(Auth::guard('admins')->id());
        return view('backend.places.edit', compact('admin', 'region', 'place'));
    }

    public function update(Request $request, Region $region, Place $place)
    {
        $validated = $request->validate([
            'place_name' => 'required|string|max:255',
            'place_info' => 'required|string|max:3000',
            'place_link' => 'required|string|max:255',
            'place_point' => 'required|integer|min:0',
            'place_image' => 'nullable|image|max:3072',
        ]);

        try {
            DB::beginTransaction();

            $place->place_name = $validated['place_name'];
            $place->place_info = $validated['place_info'];
            $place->place_link = $validated['place_link'];
            $place->place_point = $validated['place_point'];

            if ($request->hasFile('place_image')) {
                // 既存の画像をS3から削除
                if ($place->place_image) {
                    $existingImagePath = parse_url($place->place_image, PHP_URL_PATH);
                    Storage::disk('s3')->delete($existingImagePath);
                }

                // 新しい画像をアップロード
                $file = $request->file('place_image');
                $fileName = 'place_images/' . uniqid() . '.' . $file->getClientOriginalExtension();
                Storage::disk('s3')->put($fileName, file_get_contents($file), 'public');
                $url = Storage::disk('s3')->url($fileName);

                // データベースを更新
                $place->place_image = $url;
            }

            $place->save();

            DB::commit();

            return redirect()->route('admin.backend.places.index', ['region' => $region->id])
                ->with('message', '情報が更新されました');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => '更新に失敗しました。']);
        }
    }

    public function destroy(Region $region, Place $place)
    {
        // S3から画像を削除
        if ($place->place_image) {
            Storage::disk('s3')->delete(parse_url($place->place_image, PHP_URL_PATH));
        }
    
        // データベースから削除
        $place->delete();
    
        return redirect()->route('admin.backend.places.index', ['region' => $region->id])->with('success', '削除されました。');
    }

    
        // public function index2()
    // {
    //     $places = Place::where('region_id',1)->orderBy('created_at', 'asc')->get();
    // return view('meisyo', ['places' => $places]);
    // }

    // public function edit2($place_id)
    // {
    //     $places = Place::find($place_id);
    // return view('places', ['places' => $places]);
    // }

    // public function edit3($place_id)
    // {
    //     $places = Place::find($place_id);
    //     return view('places_qr', ['places' => $places]);
    // }
        // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'region_id' => 'required|integer|exists:regions,id',
    //         'place_name' => 'required|string|max:255',
    //         'place_info' => 'required|string|max:3000',
    //         'place_link' => 'required|string|max:255',
    //         'place_point' => 'required|integer|min:0', // 数値としてバリデーション
            
    //     ]);

    //     $manager = new ImageManager(new Driver());

    //     if ($validator->fails()) {
    //         return redirect('/')
    //             ->withInput()
    //             ->withErrors($validator);
    //     }
    //         // トランザクション開始
    //         DB::beginTransaction();
    
    //         $url = null;
    //         if ($request->hasFile('place_image')) {
    //             // ファイルから画像を読み込み
    //             $image = $manager->read($request->file('place_image')->getPathName());
    
    //             $image->scale(width: 1000);
    
    //             // 画像を一時的なファイルとして保存
    //             $tempPath = tempnam(sys_get_temp_dir(), 'placeImage') . '.jpg';
    //             $image->toPng()->save($tempPath);
    
    //             // 保存した一時ファイルをS3にアップロード
    //             $fileName = 'place_images/' . uniqid() . '.jpg';
    //             Storage::disk('s3')->put($fileName, file_get_contents($tempPath), 'public');
    //             $url = Storage::disk('s3')->url($fileName);
    
    //             // 一時ファイルを削除
    //             @unlink($tempPath);
    //             // $dummyImagePath = 'dummy_image.jpg';
    
    //         $place = new Place;
    //         $place->region_id = $request->input('region_id');
    //         $place->place_name = $request->input('place_name');
    //         $place->place_info = $request->input('place_info');
    //         $place->place_link = $request->input('place_link');
    //         $place->place_image = $dummyImagePath; 
    //         $place->place_point = $request->input('place_point');
    //         $place->place_image = $url;
    //         $place->save();
    //         // return redirect('/meisyo');
    
    //     //     // トランザクションコミット
    //         DB::commit();
    //         return redirect()->route('admin.backend.places.index', ['region' => $request->input('region_id')])->with('success', '登録されました。');
    //     } catch (\Exception $e) {
    //         // エラーが発生した場合はロールバック
    //         DB::rollback();
    //         Log::error($e->getMessage());
    //         return back()->withInput()->withErrors(['error' => '保存に失敗しました。']);
    //     // }
    // }
    // public function update(Request $request, Region $region, Place $place)
    // {
    //     $validated = $request->validate([
    //         'place_name' => 'required|string|max:255',
    //         'place_info' => 'required|string|max:3000',
    //         'place_link' => 'required|string|max:255',
    //         'place_point' => 'required|integer|min:0',
    //         'place_image' => 'nullable|image|max:3072',
    //     ]);
    
    //     $manager = new ImageManager(new Driver());

    //     try {
    //         DB::beginTransaction();
    
    //         // $place = Place::findOrFail($id);
    //         $place->place_name = $validated['place_name'];
    //         $place->place_info = $validated['place_info'];
    //         $place->place_link = $validated['place_link'];
    //         $place->place_point = $validated['place_point'];

    //         if ($request->hasFile('place_image')) {
    //             // 既存の画像をS3から削除
    //             if ($place->place_image) {
    //                 $existingImagePath = parse_url($place->place_image, PHP_URL_PATH);
    //                 Storage::disk('s3')->delete($existingImagePath);
    //             }
    
    //             // 新しい画像を処理
    //             $image = $manager->read($request->file('place_image')->getPathName());
    //             $image->scale(width: 300);
    //             $tempPath = tempnam(sys_get_temp_dir(), 'placeImage') . '.jpg';
    //             $image->toPng()->save($tempPath);
    
    //             // S3にアップロード
    //             $fileName = 'place_images/' . uniqid() . '.jpg';
    //             Storage::disk('s3')->put($fileName, file_get_contents($tempPath), 'public');
    //             $url = Storage::disk('s3')->url($fileName);
    
    //             // 一時ファイルを削除
    //             @unlink($tempPath);
    
    //             // データベースを更新
    //             $place->place_image = $url;
    //         }

    //         $place->save();
    
    
    //         DB::commit();
    
    //         return redirect()->route('admin.backend.places.index', ['region' => $region->id])
    //             ->with('message', '情報が更新されました');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Log::error($e->getMessage());
    //         return back()->withInput()->withErrors(['error' => '更新に失敗しました。']);
    //     }
    // }

}
