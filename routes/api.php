<?php

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\DashboardController;

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
    Route::apiResource('/customers', CustomerController::class);
    Route::get('/countries', [CustomerController::class, 'countries']);

    //Dashboard actions

    Route::get('/dashboard/total-customers', [DashboardController::class, 'activeCustomers']);
    Route::get('/dashboard/invoices-count', [DashboardController::class, 'adminInvoices']);
    Route::get('/dashboard/paidInvoices-count', [DashboardController::class, 'paidInvoices']);
    Route::get('/dashboard/income-amount', [DashboardController::class, 'totalIncome']);
    Route::get('/dashboard/latest-customers', [DashboardController::class, 'latestCustomers']);
    Route::get('/dashboard/latest-invoices', [DashboardController::class, 'latestInvoices']);
});
Route::apiResource('/product', ProductController::class);
Route::get('/sections', [ProductController::class, 'getSections']);
Route::get('/invoiceProducts', [ProductController::class, 'getInvoiceProducts']);
Route::get('/invoiceCustomers', [InvoicesController::class, 'getInvoiceCustomers']);

Route::post('/login', [AuthController::class, 'login']);
