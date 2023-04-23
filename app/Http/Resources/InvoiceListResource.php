<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'serial_number'=>$this->serial_number,
            'due_date'=>$this->due_date,
            'product_name' => $this->product->product_name,
            'product_id'=>$this->product_id,
            'customer'=> new UserCustomerResource($this->user),
            'status'=>$this->status,
            'total'=>$this->total,
            'updated_at'=>(new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
    ];
    }
}
