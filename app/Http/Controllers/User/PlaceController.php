<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    public function qr($id)
    {
        $place = Place::findOrFail($id);
        // QRコードからアクセスされた場合の処理をここに記述
        return view('user.qr', compact('place'));
    }
    
}
