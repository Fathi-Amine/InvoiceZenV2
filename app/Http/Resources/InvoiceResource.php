<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'id'=>$this->id,
            'serial_number'=>$this->serial_number,
            'invoice_Date'=>$this->invoice_Date,
            'due_date'=>$this->due_date,
            'customer_id'=>$this->customer_id,
            'customer'=> new UserCustomerResource($this->user),
            'product_id'=>$this->product_id,
            'status'=>$this->status,
            'gross_price'=>$this->gross_price,
            'discount'=>$this->discount,
            'TVA'=>$this->TVA,
            'TVA_rate'=>$this->TVA_rate,
            'total'=>$this->total,
            'note'=>$this->note,
            'payment_date'=>$this->payment_date,
            'created_by'=>$this->created_by,
            'updated_by'=>$this->updated_by,
            'created_at'=>(new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at'=>(new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
        ];
    }
}
