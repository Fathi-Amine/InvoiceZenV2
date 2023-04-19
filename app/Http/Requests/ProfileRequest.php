<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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

            'invoicing.address1' => ['required'],
            'invoicing.address2' => ['required'],
            'invoicing.city' => ['required'],
            'invoicing.state' => ['required'],
            'invoicing.zipcode' => ['required'],
            'invoicing.country_code' => ['required', 'exists:countries,code'],

            'billing.address1' => ['required'],
            'billing.address2' => ['required'],
            'billing.city' => ['required'],
            'billing.state' => ['required'],
            'billing.zipcode' => ['required'],
            'billing.country_code' => ['required', 'exists:countries,code'],
        ];
    }

    public function attributes()
    {
        return [
            'billing.address1' => 'address 1',
            'billing.address2' => 'address 2',
            'billing.city' => 'city',
            'billing.state' => 'state',
            'billing.zipcode' => 'zip code',
            'billing.country_code' => 'country',
            'invoicing.address1' => 'address 1',
            'invoicing.address2' => 'address 2',
            'invoicing.city' => 'city',
            'invoicing.state' => 'state',
            'invoicing.zipcode' => 'zip code',
            'invoicing.country_code' => 'country',
        ];
    }
}
