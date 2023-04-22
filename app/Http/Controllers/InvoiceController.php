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

    public function index(Request $request){

        $user = $request->user();
        $user = Auth::user();
        $invoices = Invoice::where('customer_id', $user->id)->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('invoice.invoices', compact('invoices'));
    }
}
