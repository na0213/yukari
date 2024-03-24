<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Place;

class RegionController extends Controller
{
    // public function index()
    // {
    //     $places = Place::where('region_id',1)->orderBy('created_at', 'asc')->get();
    //     return view('meisyo', ['places' => $places]);
    // }

    // public function show($place_id)
    // {
    //     $places = Place::find($place_id);
    //     return view('places', ['places' => $places]);
    // }

    // public function edit3($place_id)
    // {
    //     $places = Place::find($place_id);
    //     return view('places_qr', ['places' => $places]);
    // }
}
