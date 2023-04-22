<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
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

        
        $user = Auth::user();
        $invoices = Invoice::where('customer_id', $user->id)->orderBy('created_at', 'desc')
        ->paginate(2);
        return view('invoice.invoices', compact('invoices'));
    }
    public function view(Invoice $invoice){
        $user = \request()->user();
        if ($invoice->customer_id !== $user->id) {
            return response("You don't have permission to view this order", 403);
        }
        return view('invoice.view', compact('invoice','user'));
    }
}
