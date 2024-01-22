<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NewTaskRequest extends FormRequest
{
  
    public function authorize()
    {
        return Auth::check();
    }

   
    public function rules()
    {
        return [
            'text_task_name' => 'required|min:3|max:200',
            'text_task_description' => 'required|min:3|max:1000',
        ];
    }

  
    public function messages()
    {
        return [
            'text_task_name.required' => 'O campo é de preenchimento obrigatório.',
            'text_task_name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'text_task_name.max' => 'O campo deve ter no máximo :max caracteres.',
            'text_task_description.required' => 'O campo é de preenchimento obrigatório.',
            'text_task_description.min' => 'O campo deve ter no mínimo :min caracteres.',
            'text_task_description.max' => 'O campo deve ter no máximo :max caracteres.',
        ];
    }
}