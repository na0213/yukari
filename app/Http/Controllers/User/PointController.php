<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Point;

class PointController extends Controller
{
    public function index(Request $request)
    {
        $points = Point::where('user_id', $request->user()->id)->get();

        return view('user.points.index', compact('points'));
    }

    public function store(Request $request, $placeId)
    {
        $place = Place::findOrFail($placeId);

        $point = new Point();
        $point->user_id = $request->user()->id; // ログインしているユーザーのID
        $point->region_id = $place->region->id; // Place から Region の ID を取得
        $point->point = $place->place_point; // Place からポイントを取得
        $point->title = $place->place_name; // Place からタイトルを取得
        $point->save();

        return redirect()->route('user.points.index')->with('success', 'ポイントを獲得しました！');
    }
}
