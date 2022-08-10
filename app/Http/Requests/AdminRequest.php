<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['boolean']
        ];
        // 'unique:table,column,except,id'
        if (($this->method() == "POST")) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:admins'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        } else {
            // $rules['email'] = ['required', 'string', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($this->route('admin'))];
            $rules['email'] = ['required', 'string', 'email', 'max:255', "unique:admins,email,{$this->route('admin')}"];
            if ($this->password) {
                $rules['password'] = ['string', 'min:8', 'confirmed'];
            }

            if ($this->image) {
                $rules['image'] = [
                    Rule::filepond([
                        'image',
                        'mimes:png,jpeg,jpg,gif',
                        'max:5120'
                    ])
                ];
            }

            if ($this->about) {
                $rules['about'] = ['string', 'max:255'];
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => "الرجاء إدخال إسم العضو",
            'name.string' => "الرجاء إدخال إسم عضو صالح",
            'name.max' => "إسم العضو يجب ألا يزيد عن 255 حرف",
            'email.required' => "الرجاء إدخال إسم المستخدم",
            'email.string' => "الرجاء إدخال إسم مستخدم صالح",
            'email.email' => "الرجاء إدخال إيميل صالح",
            'email.max' => "إسم المستخدم يجب ألا يزيد عن 255 حرف",
            'email.unique' => "هذا البريد الإلكترونى موجود مسبقاً",
            'password.required' => "الرجاء إدخال كلمة المرور",
            'password.string' => "الرجاء إدخال كلمة مرور صالحة",
            'password.min' => "كلمة المرور يجب ألا تقل عن 8 أحرف",
            'password.confirmed' => "كلمتا المرور غير متطابقتان",
            'image.image' => "الملف المرفق يجب أن يكون صورة",
            'image.mimes' => "إمتداد المصورة يجب أن تكون jpeg او png او gif او jpeg",
            'image.max' => "حجم الصورة لا يجب أن يزيد عن 5 ميجا بايت",
            'about.string' => "الرجاء أدخل محتوى صالح فى حقل 'عن'",
            'about.max' => "عن العضو يجب ألا يزيد عن 255 حرف"
        ];
    }
}
