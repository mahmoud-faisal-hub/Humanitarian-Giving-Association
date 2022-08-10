<?php

namespace App\Http\Requests;

use App\Models\News;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
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
            'title' => "required",
            'content' => "required",
            'category_id' => "required|numeric",
            'article' => "required"
        ];

        if (($this->method() != "POST")? $this->image != News::select('image')->find($this->route('news'))->image : 1) {
            $rules['image'] = [
                "required",
                Rule::filepond([
                    'image',
                    'mimes:png,jpeg,jpg,gif',
                    'max:5120'
                ])
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'image.required' => "الصورة مطلوبة",
            'image.image' => "الملف المرفق يجب أن يكون صورة",
            'image.mimes' => "إمتداد المصورة يجب أن تكون jpeg او png او gif او jpeg",
            'image.max' => "حجم الصورة لا يجب أن يزيد عن 5 ميجا بايت",
            'title.required' => "الرجاء إدخال عنوان المقال",
            'content.required' => "الرجاء إدخال محتوى المقال",
            'category_id.required' => "الرجاء إختيار القسم",
            'category_id.numeric' => "عنوان القسم يجب أن يكون رقم",
            'article.required' => "المقال مطلوب",
        ];
    }
}
