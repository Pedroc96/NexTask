<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginTaskRequest extends FormRequest
{
    
    public function authorize()
    {
    
        return true;
    }

 
    public function rules()
    {
        return [
            'text_username' => 'required|min:3',
            'text_password' => 'required|min:3',
        ];
    }

   
    public function messages()
    {
        return [
            'text_username.required' => 'O campo é de preenchimento obrigatório.',
            'text_username.min' => 'O campo deve ter no mínimo 3 caracteres.',
            'text_password.required' => 'O campo é de preenchimento obrigatório.',
            'text_password.min' => 'O campo deve ter no mínimo 3 caracteres.',
        ];
    }
}
