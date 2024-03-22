<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            'prefecture' => 'required|string|max:255',
        ]);

        try {
            // トランザクション開始
            DB::beginTransaction();

            $region = new Region;
            $region->name = $request->input('name');
            $region->prefecture = $request->input('prefecture');
            $region->save();
    
            // トランザクションコミット
            DB::commit();
            return redirect()->route('admin.backend.regions.index')->with('success', '登録されました。');
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
            'prefecture' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();
    
            $region = Region::findOrFail($id);
            $region->name = $validated['name'];
            $region->prefecture = $validated['prefecture'];

            $region->save();
    
            DB::commit();
    
            return redirect()->route('admin.backend.regions.index')
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

        // データベースから削除
        $region->delete();
    
        return redirect()->route('admin.backend.regions.index')->with('success', '削除されました。');
    }
}
