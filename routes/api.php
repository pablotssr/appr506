<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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


// Route::middleware('auth:sanctum')->get('/api/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);
//     return ['token' => $token->plainTextToken];
// });


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::get('/events', [EventController::class, 'index']);

