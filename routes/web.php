<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\PlaceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\RegionController;
use App\Http\Controllers\PointController;
use App\Models\Point;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Topページ表示
Route::get('/', function () {
    return view('welcome');
});

// Topページ表示
Route::get('/yukari', function () {
    return view('yukari');
});

// 名所を表示:通常
Route::get('/edit2/{place}', [PlaceController::class,"edit2"])->name('edit2'); 
// 名所を表示：QRコード用
Route::get('/edit3/{place}', [PlaceController::class,"edit3"])->name('edit3');   

// 
Route::get('/meisyo', [PlaceController::class,'index2'])->middleware(['auth'])->name('place_index');

// QRコードから名所ページに行き、ボタンをポチっと押す
Route::post('/point_store',[PointController::class,"store"])->name('point_store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/regions', [RegionController::class, 'index'])->name('guest.regions.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
