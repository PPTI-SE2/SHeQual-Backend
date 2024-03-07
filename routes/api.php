<?php

use App\Http\Controllers\API\AppointmentsController;
use App\Http\Controllers\API\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\api\EditProfileController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;

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
Route::post('/login-consultant', [AuthController::class, 'loginCon']);
Route::post('/posts',[PostController::class, 'store']);
Route::post('/comments', [PostController::class, 'storeComment']);
Route::post('/consulForm', [AppointmentsController::class, 'store']);
Route::post('/like-unlike-post', [LikeController::class, 'storeLike']);
Route::get('/check-like/{posts_id}/{users_id}', [LikeController::class, 'checkLike']);

Route::get('/articles', [ArticleController::class, 'getArticle']);
Route::get('/games', [GameController::class, 'getGame']);
Route::get('/posts', [PostController::class, 'showPostComment']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/consultators', [UserController::class, 'consul_index']);
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:api');

// ini buat update dan edit user
Route::put('/profile/update', [EditProfileController::class, 'update']);
Route::put('/getPoint', [GameController::class, 'getPoint']);

