<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPasswordExtension implements Rule
{
    public function passes($attribute, $value)
    {
        // Kiểm tra mật khẩu có chứa ít nhất một chữ hoa, một chữ thường, một số và một ký tự đặc biệt
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[a-zA-Z\d\W_]{8,}$/', $value);
    }

    public function message()
    {
        return 'Mật khẩu phải chứa ít nhất 1 chữ cái viết thường, 1 chữ cái viết hoa, 1 số và 1 ký tự đặc biệt';
    }
}
