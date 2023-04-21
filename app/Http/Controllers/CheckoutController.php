<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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

          return redirect($session->url);
    }

    public function success(Request $request)
    {
      \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

      $session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
      // dd($session);
      // $customer = \Stripe\Customer::retrieve($session->customer);
     
      return view('checkout.success');
    }
}
