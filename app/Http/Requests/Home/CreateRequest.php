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
            'numbers' => 'required|max:200',
            'numbers' => 'required|min:1',
        ];
    }
}