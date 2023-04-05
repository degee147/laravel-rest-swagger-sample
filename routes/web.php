<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

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


Route::prefix('articles')->controller(ArticleController::class)->group(function () {
    Route::get('/', 'index')->name('showArticles');
    Route::get('/{id}', 'show')->name('singleArticle');
    Route::post('/{id}/comment', 'comment')->name('addComment');
    Route::get('/{id}/like', 'like')->name('addLike');
    Route::get('/{id}/view', 'view')->name('addView');
});
