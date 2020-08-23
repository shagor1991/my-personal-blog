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

Route::apiResource('/category', 'Api\CategoryController');
Route::get('search/category/{field}/{query}','Api\CategoryController@search');
Route::get('/parentcategory', 'Api\CategoryController@parent_category');
Route::apiResource('/post', 'Api\PostController');
Route::apiResource('/tag', 'Api\TagController');
Route::get('search/tags/{field}/{query}','Api\TagController@search');
