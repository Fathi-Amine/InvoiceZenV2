<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Enums\InvoiceStatus;
use Illuminate\Http\Request;
use App\Enums\CustomerStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\InvoiceResource;

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

    public function latestCustomers()
    {
    
        return Customer::query()
            ->select(['id', 'first_name', 'last_name', 'u.email', 'phone', 'u.created_at'])
            ->join('users AS u', 'u.id', '=', 'customers.user_id')
            ->where('status', CustomerStatus::Active->value)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    
    }

    public function latestInvoices()
    {

        $results = DB::table('invoices as i')
        ->leftJoin('products as p', 'p.id', '=', 'i.product_id')
        ->leftJoin('users as u', 'u.id', '=', 'i.customer_id')
        ->select('i.id', 'i.total', DB::raw("DATE_FORMAT(i.created_at, '%Y-%m-%d') as created_at"), 'p.id as product_id', 'p.product_name as product_name', 'u.id as user_id', 'u.name')
        ->where('i.status', 'paid')
        ->groupBy('i.id', 'i.total', 'created_at', 'u.id', 'u.name', 'p.id', 'p.product_name')
        ->orderBy('i.created_at', 'desc')
        ->limit(10)
        ->get();

                return $results;
        // return InvoiceResource::collection(
        //     Invoice::query()
        //     ->select(['invoices.id', 'invoices.total', 'invoices.created_at', 'products.id AS product_id', 'products.product_name AS product_name', 'customers.user_id', 'customers.first_name', 'customers.last_name'])
        //     ->leftJoin('products', 'products.id', '=', 'invoices.product_id')
        //     ->join('customers', 'customers.user_id', '=', 'invoices.customer_id')
        //     ->where('invoices.status', InvoiceStatus::Paid->value)
        //     ->limit(10)
        //     ->orderBy('invoices.created_at', 'desc')
        //     ->groupBy('invoices.id', 'invoices.total', 'invoices.created_at', 'customers.user_id', 'customers.first_name', 'customers.last_name', 'products.id', 'products.product_name')
        //     ->get()
        //     ->filter(function ($invoice) {
        //         return $invoice->product_id !== null;
        //     })
        //     $invoices = Invoice::select(
        //         'invoices.id',
        //         'invoices.total',
        //         'invoices.created_at',
        //         'products.id as product_id',
        //         'products.product_name as product_name',
        //         'customers.user_id',
        //         'customers.first_name',
        //         'customers.last_name'
        //     )
        //     ->leftJoin('products', 'products.id', '=', 'invoices.product_id')
        //     ->join('customers', 'customers.user_id', '=', 'invoices.customer_id')
        //     ->where('invoices.status', '=', 'paid')
        //     ->orderBy('invoices.created_at', 'desc')
        //     ->limit(10)
        //     ->get()
        


        // );
    }
}
