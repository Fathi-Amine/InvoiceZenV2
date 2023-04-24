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
        $invoicing = $this->invoicingAddress;
        $billing = $this->billingAddress;
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->user->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'invoicingAddress' => [
                'id' => $invoicing->id,
                'address1' => $invoicing->address1,
                'address2' => $invoicing->address2,
                'city' => $invoicing->city,
                'state' => $invoicing->state,
                'zipcode' => $invoicing->zipcode,
                'country_code' => $invoicing->country->code,
            ],
            'billingAddress' => [
                'id' => $billing->id,
                'address1' => $billing->address1,
                'address2' => $billing->address2,
                'city' => $billing->city,
                'state' => $billing->state,
                'zipcode' => $billing->zipcode,
                'country_code' => $billing->country->code,
            ],
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
