<?php

namespace App\Http\Controllers;

use App\Enums\CustomerStatus;
use App\Enums\InvoiceStatus;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function activeCustomers(){

        return Customer::query()->where('status', CustomerStatus::Active->value)->count();
    }

    public function adminInvoices(){

        return Invoice::count();
    }

    public function paidInvoices(){

        return Invoice::where('status', InvoiceStatus::Paid->value)->count();
    }

    public function totalIncome(){

        return Invoice::where('status', InvoiceStatus::Paid->value)->sum('total');
    }
}
