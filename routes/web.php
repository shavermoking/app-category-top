<?php

use App\Http\Controllers\AppTopCategoryController;
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

Route::middleware(['throttle:5,1', 'log.requests'])->get('/appTopCategory', [AppTopCategoryController::class, 'getAppTopPositions']);
