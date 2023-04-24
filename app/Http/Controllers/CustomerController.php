<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Customer;
use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Models\CustomerAddress;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerListResource;
use Illuminate\Support\Facades\DB;

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
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = Customer::query();
        $query->orderBy("customers.$sortField", $sortDirection);
        if ($search) {
            $query->join('users', 'user_id', '=', 'id')->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
        }
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
        $customerData['status'] = $customerData['status'] ? CustomerStatus::Active->value : CustomerStatus::Disabled->value;
        $invoicingData = $customerData['invoicingAddress'];
        $billingData = $customerData['billingAddress'];

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

    public function countries(){

        return CountryResource::collection(Country::query()->orderBy('name', 'asc')->get());
    }
}
