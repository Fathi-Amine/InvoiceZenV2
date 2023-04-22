<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'serial_number'=>['required'],
            'invoice_Date'=> ['required'],
            'due_date'=>['required'],
            'customer_id'=>['required', 'integer', 'exists:customers,user_id'],
            'product_id'=>['required', 'integer', 'exists:products,id'],
            'gross_price'=>['required', 'numeric'],
            'discount'=>['required', 'numeric'],
            'TVA'=>['required', 'numeric'],
            'TVA_rate'=>['required', 'numeric'],
            'total'=>['required', 'numeric'],
        ];
    }
}
