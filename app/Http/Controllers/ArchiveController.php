<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $invoices = Invoice::onlyTrashed()
            ->where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(2);
        return view('invoice.Archive_Invoices', compact('invoices'));
    }

    public function update(Request $request)
    {
         $id = $request->invoice_id;
         $flight = Invoice::withTrashed()->where('id', $id)->restore();
         return redirect('/invoices');
    }

    public function destroy(Invoice $invoice)
    {

        // dd($invoice->id);
        $invoices = Invoice::where('id', $invoice->id)->first();

            $invoices->delete();
            return redirect('/invoices');


    }
}
