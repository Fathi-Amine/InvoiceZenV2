<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Enums\AddressType;
use App\Models\CustomerAddress;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerListResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $search = request('search', false);
        $perPage = request('per_page', 5);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = Customer::query();
        $query->orderBy($sortField, $sortDirection);
        // if ($search) {
        //     $query->where('product_name', 'like', "%{$search}%");
        // }
        return CustomerListResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest  $request, Customer $customer)
    {
        //
        $customerData = $request->validated();
        $invoicingData = $customerData['invoicing'];
        $billingData = $customerData['billing'];

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
       

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //

        $customer->delete();

        return response()->noContent();
    }

}
