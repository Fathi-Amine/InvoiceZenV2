<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoicesController;

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




Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('invoice/statuses', [InvoicesController::class, 'getStatuses']);
    Route::post('invoice/change-status/{invoice}/{status}', [InvoicesController::class, 'changeStatus']);
    Route::apiResource('/invoice', InvoicesController::class);
    Route::apiResource('/users', UserController::class);
});
Route::apiResource('/product', ProductController::class);
Route::get('/sections', [ProductController::class, 'getSections']);
Route::get('/invoiceProducts', [ProductController::class, 'getInvoiceProducts']);
Route::get('/invoiceCustomers', [InvoicesController::class, 'getInvoiceCustomers']);

Route::post('/login', [AuthController::class, 'login']);
