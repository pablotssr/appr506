<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\ItemController;

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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function () {
Route::get('/pet', [PetController::class, 'showOrCreate']);
Route::post('/pet', [PetController::class,'store']);
Route::post('/pet/kill',[PetController::class,'kill']);
Route::post('/pet/diary',[PetController::class,'createDiary']);

Route::get('/auth/infos', [AuthController::class, 'infos']);

Route::post('/action/laver', [ActionController::class, 'laver']);
Route::post('/action/caresser', [ActionController::class, 'caresse']);
Route::post('/action/snake', [ActionController::class, 'snake']);
Route::post('/action/run', [ActionController::class, 'run']);
Route::post('/action/maths', [ActionController::class, 'maths']);
Route::post('/action/give', [ActionController::class, 'giveItem']);

Route::post('/event/sdf', [EventController::class, 'sdf']);
Route::post('/event/love', [EventController::class, 'love']);
Route::post('/event/dep', [EventController::class, 'dep']);
Route::post('/event/pigeon', [EventController::class, 'pigeon']);
Route::post('/event/coco', [EventController::class, 'coco']);
Route::post('/event/best', [EventController::class, 'best']);
Route::post('/event/money', [EventController::class, 'money']);

Route::post('/event/trigger', [EventController::class, 'triggerEvent']);

Route::post('/item/shop', [ItemController::class, 'createShop']);
Route::post('/item/shop/see', [ItemController::class, 'viewShop']);
Route::post('/item/inventory/see', [ItemController::class, 'viewInventory']);
Route::post('/item/buy', [ItemController::class, 'achat']);
});

Route::get('/events', [EventController::class, 'index']);



