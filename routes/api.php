<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Article;
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



Route::get('/articles', [ArticleController::class,'getAllArticles']);
Route::get('/articles/{id}',[ArticleController::class,'getArticle']);

Route::post('/articles',[ArticleController::class,'createArticle'])->middleware('auth:api');
Route::put('/articles/{article}',[ArticleController::class,'updateArticle'])->middleware('auth:api');
Route::delete('/articles/{article}',[ArticleController::class,'deleteArticle'])->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});
Route::post('/token',[ArticleController::class,'getToken']);
Route::get('/create',function(){
     User::forceCreate([
       'name'=>'jane Doe',
       'email'=> 'jadone@gmail.com',
       'password'=>Hash::make('abcd1234')
     ]);
     User::forceCreate([
       'name'=>'Kane Doe',
       'email'=> 'kadoe@gmail.com',
       'password'=>Hash::make('abcd1234')
     ]);
});

Route::get('/tokenc',function(){
   $user = User::find(1);
   $user->api_token = Str::random(80);
   $user->save();
  $user = User::find(2);
   $user->api_token = Str::random(80);
   $user->save();
   $user = User::find(10);
   $user->api_token = Str::random(80);
   $user->save();
   
});