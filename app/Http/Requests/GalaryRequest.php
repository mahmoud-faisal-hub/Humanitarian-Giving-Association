<?php

namespace App\Http\Requests;

use App\Models\Galary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalaryRequest extends FormRequest
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
        $rules = [];

        if ($this->method() == "POST") {
            $rules['galary'] = 'required';
            $rules['galary.*'] = [
                'required',
                Rule::filepond([
                    'file',
                    'mimes:png,jpeg,jpg,gif,mp4,ogv,webm,avi',
                    'max:1048576'
                ])
            ];
        } else if ($this->galary != Galary::select('file')->find($this->route('galary'))->first()->file) {
            $rules['galary'] = [
                'required',
                Rule::filepond([
                    'file',
                    'mimes:png,jpeg,jpg,gif,mp4,ogx,oga,ogv,ogg,webm,avi',
                    'max:1048576'
                ])
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'galary.file' => "الملف المرفق يجب أن يكون ملف صالح",
            'galary.mimes' => "إمتداد المصورة يجب أن تكون jpeg او png او gif او jpeg او mp4 او ogx او oga او ogv او ogg او webm او avi",
            'galary.max' => "حجم الملف لا يجب أن يزيد عن 1 جيجا بايت",
            'galary.required' => "الملف مطلوب",
        ];
    }
}
