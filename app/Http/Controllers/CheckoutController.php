<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceStatus;
use App\Enums\PaymentStatus;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        $user = Auth::user();
        $latest_invoice = Invoice::where('customer_id', $user->id)
                          ->where('status', 'draft')
                          ->orderBy('created_at', 'desc')
                          ->first();
        $line_items = [];
        $line_items[] = [
          'price_data' => [
            'currency' => 'usd',
            'product_data' => [
              'name' => $latest_invoice->product->product_name,
            ],
            'unit_amount_decimal' => $latest_invoice->total * 100,
          ],
          'quantity' => 1,
        ];
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
          ]);

          $latest_invoice->update([
            'status' => InvoiceStatus::Processing,
            'updated_by' => $user->id,
          ]);

          $payment_data = [
            'invoice_id'=> $latest_invoice->id,
            'amount'=> $latest_invoice->total,
            'status'=>PaymentStatus::Pending,
            'type'=>'cc',
            'created_by'=> $user->id,
            'updated_by'=> $user->id,
            'session_id'=> $session->id
          ];

          $payment = Payment::create($payment_data);

          return redirect($session->url);
    }

    public function success(Request $request)
    {
      \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

      
      try {
        $session_id = $request->get('session_id');
        $session = \Stripe\Checkout\Session::retrieve($session_id);
        // dd($session);
        if (!$session) {
          return view('checkout.failure');
        };

        $payment = Payment::query()->where(['session_id'=>$session->id, 'status' => PaymentStatus::Pending])->first();
       

        if(!$payment){
          return view('checkout.failure');
        }

        $payment->status = PaymentStatus::Paid;
        $payment->update();
        $invoice = $payment->invoice;
        $invoice->status = InvoiceStatus::Paid;
        $invoice->update();
        
        return view('checkout.success');

      } catch (\Exception $e) {
        
        return view('checkout.failure');
      }
     
    }

    public function failure(Request $request)
    {
        return view('checkout.failure', ['message' => ""]);
    }

    public function checkoutInvoice(Invoice $invoice, Request $request)
    {

        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        $user = Auth::user();
        $line_items = [];
        $line_items[] = [
          'price_data' => [
            'currency' => 'usd',
            'product_data' => [
              'name' => $invoice->product->product_name,
            ],
            'unit_amount_decimal' => $invoice->total * 100,
          ],
          'quantity' => 1,
        ];
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
          ]);

          $invoice->update([
            'status' => InvoiceStatus::Processing,
            'updated_by' => $user->id,
          ]);

          $payment_data = [
            'invoice_id'=> $invoice->id,
            'amount'=> $invoice->total,
            'status'=>PaymentStatus::Pending,
            'type'=>'cc',
            'created_by'=> $user->id,
            'updated_by'=> $user->id,
            'session_id'=> $session->id
          ];

          $payment = Payment::create($payment_data);

          return redirect($session->url);

    }
}
