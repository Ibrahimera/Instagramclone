<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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


Route::get('/like/{id}',[LikeController::class,'index']);
Route::get('/login/all',[LoginController::class,'index']);
Route::post('/login/all',[LoginController::class,'store']);
Route::post('/register',[RegisterController::class,'register']);
Route::get('/logout/all',[LoginController::class,'logout']);
Route::get('/comment/{pId}',[CommentController::class,'index']);
Route::post('/comment/all',[CommentController::class,'store']);
Route::get('/follow/all/{username}',[FollowController::class,'store']);
Route::post('/follow/all/',[FollowController::class,'index']);
Route::post('/like/all',[LikeController::class,'store']);
Route::get('/profile/{username}',[ProfileController::class,'index']);
Route::post('/profile/{username}',[ProfileController::class,'store']);
Route::post('/post/all',[PostController::class,'store']);
Route::get('/search/{username}',[SearchController::class,'search']);
Route::get('/activity/all',[ActivityController::class,'index']);
Route::get('/',[HomeController::class,'index']);
Route::post('/',[HomeController::class,'store']);
Route::get('/{username}',[AjaxController::class,'index']);