<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    //

    public function indexLatest()
    {
        //
        $user = Auth::user();
        $invoices = Invoice::where('customer_id', $user->id)->get();
        return view('dashboard', ['invoices' => $invoices]);
    }
}
