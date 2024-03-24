<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\RegionController;
use App\Http\Controllers\User\PlaceController;
use App\Http\Controllers\User\PointController;

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

// 地域
// 地域名称ページ表示
Route::get('/regions', [RegionController::class, 'index'])->name('guest.regions.index');
Route::get('/regions/{place}', [RegionController::class, 'show'])->name('guest.regions.show');
// Topページ表示
// Route::get('/yukari', function () {
//     return view('yukari');
// });

// 名所を表示:通常
// Route::get('/edit2/{place}', [PlaceController::class,"edit2"])->name('edit2'); 
// 名所を表示：QRコード用
// Route::get('/edit3/{place}', [PlaceController::class,"edit3"])->name('edit3');   

// 
// Route::get('/meisyo', [PlaceController::class,'index2'])->middleware(['auth'])->name('place_index');

// QRコードから名所ページに行き、ボタンをポチっと押す
Route::post('/point_store',[PointController::class,"store"])->name('point_store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // QRコード読み込み
    Route::get('/qr/{place}', [PlaceController::class, 'qr'])->name('user.qr');
    // QRコード読み込み後のポイント取得
    Route::post('/points/{place}', [PointController::class, 'store'])->name('user.points.store');
    // ユーザーポイント取得履歴
    Route::get('/points', [PointController::class, 'index'])->name('user.points.index');
});

require __DIR__.'/auth.php';
