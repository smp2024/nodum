<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test', 'Blog\ApiController@test')->name('test');
Route::post('/category/change-status/', 'Blog\ApiController@changeCategoryStatus');
// APIS GET SEARCH
Route::get('/categories/search', 'Blog\ApiController@getCategorySearch')->name('getCategorySearch');
Route::post('/upload-massive', 'Blog\ApiController@uploadMassiveArticle')->name('massive_add');
