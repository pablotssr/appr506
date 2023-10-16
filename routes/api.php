<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ActionController;
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


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::middleware(['auth:sanctum'])->group(function () {
Route::get('/pet', [PetController::class, 'showOrCreate']);
Route::post('/pet', [PetController::class,'store']);
Route::post('/pet/kill',[PetController::class,'kill']);
Route::post('/pet/laver', [ActionController::class, 'laver']);
Route::post('/pet/caresser', [ActionController::class, 'caresse']);
Route::post('/pet/snake', [ActionController::class, 'snake']);
});

Route::get('/events', [EventController::class, 'index']);



