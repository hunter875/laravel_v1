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
        return 'The :attribute must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
    }
}
