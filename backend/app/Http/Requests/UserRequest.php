<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidEmailExtension;
use App\Rules\ValidPasswordExtension;

class UserRequest extends FormRequest
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
        $user = $this->route('user');
        $userId = is_object($user) ? $user->id : (is_numeric($user) ? $user : null);
    
        $rules = [
            'name'       => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($userId)],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
                new ValidEmailExtension(),
            ],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'role_id'    => ['nullable', 'exists:roles,id'],
            'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    
        // Check conditions for POST method (creating a new user)
        if ($this->isMethod('post')) {
            $rules += [
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:32',
                    new ValidPasswordExtension(),
                ],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name'  => ['required', 'string', 'max:255'],
                'role_id'    => ['required', 'exists:roles,id'],
                'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // If no password is entered, do not require password
            if ($this->input('password') === null) {
                $rules['password'] = ['nullable', 'string', 'min:8', 'max:32', new ValidPasswordExtension()];
            } else {
                $rules['password'] = [
                    'required',
                    'string',
                    'min:8',
                    'max:32',
                    new ValidPasswordExtension(),
                ];
            }
        }
    
        return $rules;
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
            'email.string'        => 'Email must be a valid string.',
            'email.email'         => 'Email is not in the correct format.',
            'email.max'           => 'Email cannot exceed :max characters.',
            'email.unique'        => 'Email already exists in the system.',

            'password.string'     => 'Password must be a valid string.',
            'password.min'        => 'Password must be at least :min characters.',
            'password.confirmed'  => 'Password confirmation does not match.',

            'first_name.string'   => 'First name must be a valid string.',
            'first_name.max'      => 'First name cannot exceed :max characters.',
            
            'last_name.string'    => 'Last name must be a valid string.',
            'last_name.max'       => 'Last name cannot exceed :max characters.',

            'role_id.exists'      => 'Role is invalid.',

            'avatar.image'        => 'Avatar must be an image file.',
            'avatar.mimes'        => 'Avatar must be of type: jpeg, png, jpg, gif.',
            'avatar.max'          => 'Avatar cannot exceed 2MB (2048KB).',
        ];
    }

    /**
     * Prepare data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'first_name' => $this->input('first_name', ''),
            'last_name' => $this->input('last_name', ''),
            'role_id' => $this->input('role_id', 3), // Default role_id if not provided
        ]);
    }
}
