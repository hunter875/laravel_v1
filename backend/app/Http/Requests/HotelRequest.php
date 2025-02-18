<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\rules\ValidEmailExtension;

class HotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow the user to send the request
    }

    public function rules(): array
    {
        return [
            'hotel_code'   => ['required', 'string', 'max:50', Rule::unique('hotels', 'hotel_code')->ignore($this->route('hotel'))],
            'hotel_name'   => ['required', 'string', 'max:255', Rule::unique('hotels', 'hotel_name')->ignore($this->route('hotel'))],
            'address1'     => ['nullable', 'string', 'max:255'],
            'address2'     => ['nullable', 'string', 'max:255'],
            'city_id'      => ['required', 'integer', 'exists:cities,id'],
            'telephone'    => ['required', 'digits_between:10,11'],
            'email'        => ['required', 'email', 'max:255', new ValidEmailExtension()],
            'fax'          => ['nullable', 'digits_between:10,11'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'tax_code'     => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'hotel_code.required'   => 'Hotel code cannot be empty.',
            'hotel_code.unique'     => 'Hotel code already exists.',

            'hotel_name.required'   => 'Hotel name cannot be empty.',
            'hotel_name.string'     => 'Hotel name must be a valid string.',
            'hotel_name.max'        => 'Hotel name cannot exceed :max characters.',

            'address1.required'     => 'Address cannot be empty.',
            'address1.string'       => 'Address must be a valid string.',
            'address1.max'          => 'Address cannot exceed :max characters.',

            'address2.string'       => 'Additional address must be a valid string.',
            'address2.max'          => 'Additional address cannot exceed :max characters.',

            'city_id.required'      => 'Please select a city.',
            'city_id.integer'       => 'City ID must be an integer.',
            'city_id.exists'        => 'City is invalid.',

            'telephone.required'    => 'Telephone number cannot be empty.',
            'telephone.digits_between' => 'Telephone number must be between 10-11 digits.',

            'email.required'        => 'Email cannot be empty.',
            'email.email'           => 'Email is not in the correct format.',
            'email.max'             => 'Email cannot exceed :max characters.',
            'email.unique'          => 'This email already exists in the system.',

            'fax.digits_between'    => 'Fax number must be between 10-11 digits.',

            'company_name.string'   => 'Company name must be a valid string.',
            'company_name.max'      => 'Company name cannot exceed :max characters.',

            'tax_code.string'       => 'Tax code must be a valid string.',
            'tax_code.max'          => 'Tax code cannot exceed :max characters.',
            'tax_code.unique'       => 'This tax code already exists.',
        ];
    }
}
