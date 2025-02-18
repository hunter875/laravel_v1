<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidEmailExtension;
use App\Rules\ValidPasswordExtension;

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
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => [
                'required', 
                'email', 
                Rule::unique('users', 'email')->ignore(auth()->id()),
                new     ValidEmailExtension(),
            ],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'password' => [
                'required',
                'string',
                'min:8', // Ensure password has at least 8 characters
               
                new ValidPasswordExtension(),
            ],
            'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    /**
     * Return custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required'       => 'Name cannot be empty.',
            'name.string'         => 'Name must be a valid string.',
            'name.max'            => 'Name cannot exceed :max characters.',
            
            'email.required'      => 'Email cannot be empty.',
            'email.email'         => 'Email is not in the correct format.',
            'email.unique'        => 'Email already exists in the system.',

            'first_name.string'   => 'First name must be a valid string.',
            'first_name.max'      => 'First name cannot exceed :max characters.',
            
            'last_name.string'    => 'Last name must be a valid string.',
            'last_name.max'       => 'Last name cannot exceed :max characters.',

            'password.string'     => 'Password must be a valid string.',
            'password.min'        => 'Password must be at least :min characters.',
            'password.regex'      => 'Password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.',

            'avatar.image'        => 'Avatar must be an image file.',
            'avatar.mimes'        => 'Avatar must be of type: jpeg, png, jpg, gif.',
            'avatar.max'          => 'Avatar cannot exceed :max KB.',
        ];
    }
}
