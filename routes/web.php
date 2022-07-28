<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelpGuideController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::resource('/help-guide',HelpGuideController::class);
    Route::get('/load-help-guide',[HelpGuideController::class,'loadOwnHelpGuides']);
    Route::delete('/image/{id}', [ImageController::class,'deleteImage'])->name('image.destroy');

    Route::get('/logout', [HomeController::class,'logout'])->name('logout');
   
});
