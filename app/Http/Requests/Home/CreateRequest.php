<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'numbers' => 'required|max:1000',
            'numbers' => 'required|min:1',
        ];
    }

    public function messages()
    {
        return [
            'numbers.required' => '人数を入力して下さい。',
        ];
    }
}