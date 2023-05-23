<?php

use App\Http\Controllers\LoginController;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [LoginController::class,'getData']);
    Route::post('/logout',[LoginController::class,'logout']);
});

Route::post('/register',[LoginController::class,'regist'])->middleware('guest');
Route::post('/login',[LoginController::class,'authenticate'])->middleware('guest');
Route::get('/test', function(){
    $data = Auth::user();
    return response()->json([
        'data'=>$data,
    ]);
});
Route::get('/error',[LoginController::class,'error'])->name('login');
