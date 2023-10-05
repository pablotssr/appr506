<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
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

Route::get('login/{provider}', 'AuthController@redirectToProvider');
Route::get('login/{provider}/callback', 'AuthController@handleProviderCallback');

Route::get('/social-login', function () {
    return view('social-login');
});
