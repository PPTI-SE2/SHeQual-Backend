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
Route::post('/makeConsultator', [AuthController::class, 'makeConsultator']);
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
Route::get('/point', [GameController::class, 'getPoint']);
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:api');
Route::post('/getConsultant', [AppointmentsController::class, 'getConsultant']);
Route::get('/userAppointment', [AppointmentsController::class, 'getAppointment']);
Route::get('/consultantBooking', [AppointmentsController::class, 'consultantBooking']);
Route::get('/mentalList', [AppointmentsController::class, 'mentalList']);
Route::get('/isBayar', [AppointmentsController::class, 'isBayar']);

Route::put('/profile/update', [EditProfileController::class, 'update']);
Route::put('/putPoint', [GameController::class, 'putPoint']);
Route::put('/payment', [AppointmentsController::class, 'putPayAppointment']);
Route::put('/consultantConfirm', [AppointmentsController::class, 'consultantConfirmed']);
Route::put('/cancellAppointment', [AppointmentsController::class, 'cancellAppointment']);

