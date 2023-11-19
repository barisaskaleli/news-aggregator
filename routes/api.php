<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController as AuthController;
use \App\Http\Controllers\NewsController as NewsController;
use \App\Http\Controllers\AuthorController as AuthorController;
use \App\Http\Controllers\SourceController as SourceController;
use \App\Http\Controllers\CategoryController as CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], static function () {
    Route::post('/create', [AuthController::class, 'store']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::group(['middleware' => ['auth:sanctum']], static function () {
    Route::get('/get-news', [NewsController::class, 'getLatestNews']);
    Route::post('/get-news', [NewsController::class, 'getNewsByFilter']);
    Route::post('/get-authors', [AuthorController::class, 'getAuthors']);
    Route::post('/get-categories', [CategoryController::class, 'getCategories']);
    Route::post('/get-sources', [SourceController::class, 'getSources']);
});
