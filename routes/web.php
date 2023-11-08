<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/snake', function(){
    return view('snake');
});

Route::get('/run', function(){
    return view('run');
});


Route::get('/maths', function(){
    return view('maths');
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/home', function(){
        return view('home');
    });

    Route::get('/pets', [PetController::class, 'showOrCreate']);
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
});


// Route::get('/logout', [AuthController::class, 'logout']);
Route::get('login/{provider}', [AuthController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

Route::get('/social-login', function () {
    return view('social-login');
});
