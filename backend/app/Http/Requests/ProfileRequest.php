<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện request này không.
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
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => [
                'required', 
                'email', 
                Rule::unique('users', 'email')->ignore(auth()->id())
            ],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'password'   => ['nullable', 'string', 'min:6'],
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
            'email.email'         => 'Email không đúng định dạng.',
            'email.unique'        => 'Email đã tồn tại trong hệ thống.',

            'first_name.string'   => 'Họ phải là một chuỗi ký tự hợp lệ.',
            'first_name.max'      => 'Họ không được vượt quá :max ký tự.',
            
            'last_name.string'    => 'Tên phải là một chuỗi ký tự hợp lệ.',
            'last_name.max'       => 'Tên không được vượt quá :max ký tự.',

            'password.string'     => 'Mật khẩu phải là một chuỗi ký tự hợp lệ.',
            'password.min'        => 'Mật khẩu phải có ít nhất :min ký tự.',

            'avatar.image'        => 'Ảnh đại diện phải là một tệp hình ảnh.',
            'avatar.mimes'        => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif.',
            'avatar.max'          => 'Ảnh đại diện không được vượt quá :max KB.',
        ];
    }
}
