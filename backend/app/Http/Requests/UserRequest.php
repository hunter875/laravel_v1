<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện yêu cầu này không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Lấy danh sách các quy tắc xác thực.
     */
    public function rules(): array
    {
        $userId = $this->user ? $this->user->id : null; // Lấy ID an toàn
    
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'role_id'    => ['nullable', 'exists:roles,id'],
            'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    /**
     * Trả về thông báo lỗi tùy chỉnh.
     */
    public function messages(): array
    {
        return [
            'name.required'       => 'Tên không được để trống.',
            'name.string'         => 'Tên phải là một chuỗi ký tự hợp lệ.',
            'name.max'            => 'Tên không được vượt quá :max ký tự.',
            
            'email.required'      => 'Email không được để trống.',
            'email.string'        => 'Email phải là một chuỗi ký tự hợp lệ.',
            'email.email'         => 'Email không đúng định dạng.',
            'email.max'           => 'Email không được vượt quá :max ký tự.',
            'email.unique'        => 'Email đã tồn tại trong hệ thống.',

            'password.string'     => 'Mật khẩu phải là một chuỗi ký tự hợp lệ.',
            'password.min'        => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed'  => 'Mật khẩu xác nhận không khớp.',

            'first_name.string'   => 'Họ phải là một chuỗi ký tự hợp lệ.',
            'first_name.max'      => 'Họ không được vượt quá :max ký tự.',
            
            'last_name.string'    => 'Tên phải là một chuỗi ký tự hợp lệ.',
            'last_name.max'       => 'Tên không được vượt quá :max ký tự.',

            'role_id.exists'      => 'Vai trò không hợp lệ.',

            'avatar.image'        => 'Ảnh đại diện phải là một tệp hình ảnh.',
            'avatar.mimes'        => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif.',
            'avatar.max'          => 'Ảnh đại diện không được vượt quá 2MB (2048KB).',
        ];
    }
}
