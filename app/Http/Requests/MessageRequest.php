<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => "required",
            'email' => "required|email",
            'phone' => "required|numeric",
            'message' => "required",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "الإسم مطلوب",
            'email.required' => "الإيميل مطلوب",
            'email.email' => "الرجاء إدخال الإيميل بشكل صحيح",
            'phone.required' => "رقم الهاتف مطلوب",
            'phone.numeric' => "رقم الهاتف يجب أن يتكون من أرقام فقط",
            'message.required' => "الرسالة مطلوبة",
        ];
    }
}
