<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserValidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone_number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'فیلد ایمیل الزامی است',
            'email.unique'  => 'ایمیل نمیتواند تکراری باشد',
            'email.email'  => 'فرمت ایمیل اشتباه است',
            'password.required'  => 'فیلد پسورد الزامی است',
            'password.min'  => 'فیلد پسورد نمیتواند کمتر از 6 کاراکتر باشد',
            'phone_number.required'  => 'فیلد شماره موبایل الزامی است',
        ];
    }
}
