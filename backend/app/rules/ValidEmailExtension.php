<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEmailExtension implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|edu)$/', $value);
    }
    
    public function message()
    {
        return trans('email must be in the format: edu, ac.vn, gov.vn, org.vn, net.vn, com.vn, vn');
    }
}