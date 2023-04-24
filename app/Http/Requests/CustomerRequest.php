<?php

namespace App\Http\Requests;

use App\Enums\CustomerStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone' => ['required', 'min:7'],
            'email' => ['required', 'email'],
            'status' => ['required','boolean'],

            'invoicingAddress.address1' => ['required'],
            'invoicingAddress.address2' => ['required'],
            'invoicingAddress.city' => ['required'],
            'invoicingAddress.state' => ['required'],
            'invoicingAddress.zipcode' => ['required'],
            'invoicingAddress.country_code' => ['required', 'exists:countries,code'],

            'billingAddress.address1' => ['required'],
            'billingAddress.address2' => ['required'],
            'billingAddress.city' => ['required'],
            'billingAddress.state' => ['required'],
            'billingAddress.zipcode' => ['required'],
            'billingAddress.country_code' => ['required', 'exists:countries,code'],
        ];
    }

    public function attributes()
    {
        return [
            'billingAddress.address1' => 'address 1',
            'billingAddress.address2' => 'address 2',
            'billingAddress.city' => 'city',
            'billingAddress.state' => 'state',
            'billingAddress.zipcode' => 'zip code',
            'billingAddress.country_code' => 'country',
            'invoicingAddress.address1' => 'address 1',
            'invoicingAddress.address2' => 'address 2',
            'invoicingAddress.city' => 'city',
            'invoicingAddress.state' => 'state',
            'invoicingAddress.zipcode' => 'zip code',
            'invoicingAddress.country_code' => 'country',
        ];
    }
}
