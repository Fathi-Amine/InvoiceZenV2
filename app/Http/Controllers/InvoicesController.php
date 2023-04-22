<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceListResource;

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
        $query = Invoice::query();
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

        return new InvoiceResource(Invoice::create($request->validated()));
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
}
