<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'section_id' => $this->section_id,
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
