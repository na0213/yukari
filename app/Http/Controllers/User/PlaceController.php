<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    public function index()
    {
        // 全ての名所を取得し、それに紐づく地域も一緒にロード
        $places = Place::with('region')->get();

        return view('user.places.index', compact('places'));
    }

    public function show($id)
    {
        $place = Place::with('region')->findOrFail($id);
        return view('user.places.show', compact('place'));
    }

    public function qr($id)
    {
        $place = Place::findOrFail($id);
        // QRコードからアクセスされた場合の処理をここに記述
        return view('user.qr', compact('place'));
    }

}
