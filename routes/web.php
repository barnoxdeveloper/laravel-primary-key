<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProductsWithIdController, ProductWithUlidController};

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

// Route With ID
Route::resource('product-with-id', ProductsWithIdController::class)->only(['index', 'store', 'edit', 'destroy']);

// Route With ULID
Route::resource('product-with-ulid', ProductWithUlidController::class)->only(['index', 'store', 'edit', 'destroy']);
