<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function view(Request $request)
    {
        $user = $request->user();
        $customer = $user->customer;
        $invoicingAddress = $customer->invoicingAddress ?: new CustomerAddress(['type' => AddressType::Invoicing]);
        $billingAddress = $customer->billingAddress ?: new CustomerAddress(['type' => AddressType::Billing]);
        //        dd($customer, $shippingAddress->attributesToArray(), $billingAddress, $billingAddress->customer);
        $countries = Country::query()->orderBy('name')->get();
        return view('profile.view', compact('customer', 'user', 'invoicingAddress', 'billingAddress', 'countries'));
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */


    public function store(ProfileRequest $request)
    {
        $customerData = $request->validated();
        $invoicingData = $customerData['invoicing'];
        $billingData = $customerData['billing'];

        $user = $request->user();
        $customer = $user->customer;

        $customer->update($customerData);

        if ($customer->invoicingAddress) {
            $customer->invoicingAddress->update($invoicingData);
        } else {
            $invoicingData['customer_id'] = $customer->user_id;
            $invoicingData['type'] = AddressType::Invoicing->value;
            CustomerAddress::create($invoicingData);
        }
        if ($customer->billingAddress) {
            $customer->billingAddress->update($billingData);
        } else {
            $billingData['customer_id'] = $customer->user_id;
            $billingData['type'] = AddressType::Billing->value;
            CustomerAddress::create($billingData);
        }

        $request->session()->flash('flash_message', 'Profile was successfully updated.');

        return redirect()->route('profile');
    }


    public function passwordUpdate(PasswordUpdateRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $passwordData = $request->validated();

        $user->password = Hash::make($passwordData['new_password']);
        $user->save();

        $request->session()->flash('flash_message', 'Your password was successfully updated.');

        return redirect()->route('profile');
    }



    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
