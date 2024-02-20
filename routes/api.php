<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ArticleController;

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


Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::post('/posts',[PostController::class, 'store']);
Route::post('/{id}/comments', [PostController::class, 'storeComment']);
Route::post('/like-unlike-post', [LikeController::class, 'storeLike']);
Route::get('/check-like/{posts_id}/{users_id}', [LikeController::class, 'checkLike']);

Route::get('/articles', [ArticleController::class, 'getArticle']);
Route::get('/games', [GameController::class, 'getGame']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/profile', [UserController::class, 'profile'])->middleware('auth:api');

