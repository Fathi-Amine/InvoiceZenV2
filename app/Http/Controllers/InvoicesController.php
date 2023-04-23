<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceListResource;
use App\Models\Customer;

class InvoicesController extends Controller
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
        $query = Invoice::query();
        $query->orderBy($sortField, $sortDirection);
        if($search){
            $query->where('serial_number', 'like', "%{$search}%")->orWhere('status', 'like', "%{$search}%");
        }
        return InvoiceListResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        //
        $invoice_data = $request->validated();
        $invoice_data["status"] = InvoiceStatus::Draft->value;
        $invoice_data["created_by"] = $request->user()->id;
        $invoice_data["updated_by"] = $request->user()->id;
        $invoice = Invoice::create($invoice_data);

        return new InvoiceResource($invoice);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        //
        $invoice->update($request->validated());
        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //

        $invoice->delete();
        return response()->noContent();
    }

    public function getInvoiceCustomers(){
        return Customer::all();
    }
}
