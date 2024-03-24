<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        // ここで必要なデータを取得する処理を記述する
        // 例えば、地域情報を取得するコードなど

        return view('guest.regions.index');
    }

}
