<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;
use Validator; 
use Auth;

class PointController extends Controller
{
     public function index()
    {
    
    }

     public function create()
     {
         //
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
              //バリデーション
    //  $validator = Validator::make($request->all(), [
    //       'point' => 'required|min:3|max:255',
    //       'local_explain' => 'required|min:3|max:500',
    //       'local_picture' => 'required|min:3|max:500'
    //  ]);
 
     //バリデーション:エラー 
    //  if ($validator->fails()) {
    //      return redirect('/')
    //          ->withInput()
    //          ->withErrors($validator);
    //  }
     //以下に登録処理を記述（Eloquentモデル）
 
   // Eloquentモデル
   $points = new Point;
   $points->user_id   = Auth::user()->id;
   $points->region_id = $request->place_id;//ここ注意！ローカルidをリージョンidに入れてます。
   $points->point = $request->point;
   $points->title = $request->title;
   $points->save(); 
   return redirect('/yukari');
   
     }
 
     /**
      * Display the specified resource.
      */
     public function show(Local $local)
     {
         //
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Local $local)
     {
         //
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, Local $local)
     {
         //
     }
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy(Local $local)
     {
         //
     }
}
