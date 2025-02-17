<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép người dùng gửi request
    }

    public function rules(): array
    {
        return [
            'hotel_code'   => ['required', 'string', 'max:50', Rule::unique('hotels', 'hotel_code')->ignore($this->route('hotel'))],
            'hotel_name'   => ['required', 'string', 'max:255'],
            'address1'     => ['required', 'string', 'max:255'],
            'address2'     => ['nullable', 'string', 'max:255'],
            'city_id'      => ['required', 'integer', 'exists:cities,id'],
            'telephone'    => ['required', 'digits_between:10,11'],
            'email'        => ['required', 'email', 'max:255', Rule::unique('hotels', 'email')->ignore($this->route('hotel'))],
            'fax'          => ['nullable', 'digits_between:10,11'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'order_date'   => ['nullable', 'date'],
            'tax_code'     => ['nullable', 'string', 'max:255', Rule::unique('hotels', 'tax_code')->ignore($this->route('hotel'))],
        ];
    }

    public function messages(): array
    {
        return [
            'hotel_code.required'   => 'Mã khách sạn không được để trống.',
            'hotel_code.unique'     => 'Mã khách sạn đã tồn tại.',

            'hotel_name.required'   => 'Tên khách sạn không được để trống.',
            'hotel_name.string'     => 'Tên khách sạn phải là một chuỗi ký tự hợp lệ.',
            'hotel_name.max'        => 'Tên khách sạn không được vượt quá :max ký tự.',

            'address1.required'     => 'Địa chỉ không được để trống.',
            'address1.string'       => 'Địa chỉ phải là một chuỗi ký tự hợp lệ.',
            'address1.max'          => 'Địa chỉ không được vượt quá :max ký tự.',

            'address2.string'       => 'Địa chỉ bổ sung phải là một chuỗi ký tự hợp lệ.',
            'address2.max'          => 'Địa chỉ bổ sung không được vượt quá :max ký tự.',

            'city_id.required'      => 'Vui lòng chọn thành phố.',
            'city_id.integer'       => 'ID thành phố phải là số nguyên.',
            'city_id.exists'        => 'Thành phố không hợp lệ.',

            'telephone.required'    => 'Số điện thoại không được để trống.',
            'telephone.digits_between' => 'Số điện thoại phải từ 10-11 chữ số.',

            'email.required'        => 'Email không được để trống.',
            'email.email'           => 'Email không đúng định dạng.',
            'email.max'             => 'Email không được vượt quá :max ký tự.',
            'email.unique'          => 'Email này đã tồn tại trong hệ thống.',

            'fax.digits_between'    => 'Fax phải từ 10-11 chữ số.',

            'company_name.string'   => 'Tên công ty phải là một chuỗi ký tự hợp lệ.',
            'company_name.max'      => 'Tên công ty không được vượt quá :max ký tự.',

            'order_date.date'       => 'Ngày đặt hàng phải là một ngày hợp lệ.',

            'tax_code.string'       => 'Mã số thuế phải là một chuỗi ký tự hợp lệ.',
            'tax_code.max'          => 'Mã số thuế không được vượt quá :max ký tự.',
            'tax_code.unique'       => 'Mã số thuế này đã tồn tại.',
        ];
    }
}
