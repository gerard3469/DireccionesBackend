<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phones' => 'array',
            'phones.*.phone' => 'required|string|max:20',
            'emails' => 'array',
            'emails.*.email' => 'required|email|max:255',
            'addresses' => 'array',
            'addresses.*.address' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'phones.*.phone.required' => 'Each phone number is required.',
            'emails.*.email.required' => 'Each email address is required.',
            'emails.*.email.email' => 'Each email address must be a valid email.',
            'addresses.*.address.required' => 'Each address is required.',
        ];
    }
}
