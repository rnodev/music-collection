<?php

use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\AlbumController::class,'index'])->middleware('auth');

Auth::routes();

Route::resource('albums', AlbumController::class)->middleware('auth');

Route::get('/logout', function () {

    Auth::logout();
    return redirect('/login');
});




