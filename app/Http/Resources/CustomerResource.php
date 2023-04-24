<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CustomerAddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->user->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'invoiceAddress'=>new CustomerAddressResource($this->customer->invoicingAddress),
            'billingAddress'=>new CustomerAddressResource($this->customer->billingAddress),
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
