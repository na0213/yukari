<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;

class RegionController extends Controller
{
    public function index()
    {
        // 全ての名所を取得し、それに紐づく地域も一緒にロード
        $places = Place::with('region')->get();

        return view('guest.regions.index', compact('places'));
    }

}
