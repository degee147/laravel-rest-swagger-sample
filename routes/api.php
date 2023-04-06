<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//had to comment out ->prefix('api) from RouteServiceProvider class
//the requested endpoints in the test instruction didn't specify adding the api prefix in the url path
Route::prefix('articles')->controller(ArticleController::class)->group(function () {
    Route::get('/', 'index')->name('showArticles');
    Route::get('/{id}', 'show')->name('singleArticle');
    Route::post('/{id}/comment', 'comment')->name('addComment');
    Route::get('/{id}/like', 'like')->name('addLike');
    Route::get('/{id}/view', 'view')->name('addView');
});
