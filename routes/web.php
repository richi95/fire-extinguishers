<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FireExtinguisherController;

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
    return view('index');
});

Route::get('/welcome', function () {
    return view('welcome');
});
Route::group(['prefix'=>'fire-extinguishers'], function(){
    Route::get('/', [FireExtinguisherController::class, 'index']);
    Route::post('/', [FireExtinguisherController::class, 'add']);
    Route::post('/update', [FireExtinguisherController::class, 'update_service']);
    Route::put('/{fireExtinguisher}', [FireExtinguisherController::class, 'update_fe']);
    Route::delete('/{fireExtinguisher}', [FireExtinguisherController::class, 'delete']);
    Route::get('/generate-pdf', [FireExtinguisherController::class, 'generate_pdf']);
});
