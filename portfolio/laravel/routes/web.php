<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactRequestController;

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

Route::post('/contact-requests', [ContactRequestController::class, 'store'])->middleware('throttle:5,1');
Route::get('/_private-inbox/d7f4a9c2e81b6d03a5f790ce42b18e6f9a0c5d73b2e84f16', [ContactRequestController::class, 'index']);

Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');
