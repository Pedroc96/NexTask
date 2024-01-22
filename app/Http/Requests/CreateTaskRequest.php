<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CreateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'text_task_name' => [
                'required',
                'min:3',
                'max:200',
                Rule::unique('tasks', 'task_name')
                    ->where(function ($query) {
                        $userId = Auth::id();
                        return $query->where('id_user', $userId)
                                     ->whereNull('deleted_at');
                    })
            ],
            'text_task_description' => 'required|min:3|max:1000',
        ];
    }

   
    public function messages()
    {
        return [
            'text_task_name.required' => 'O campo é de preenchimento obrigatório.',
            'text_task_name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'text_task_name.max' => 'O campo deve ter no máximo :max caracteres.',
            'text_task_name.unique' => 'Já existe uma tarefa com o mesmo nome.',
            'text_task_description.required' => 'O campo é de preenchimento obrigatório.',
            'text_task_description.min' => 'O campo deve ter no mínimo :min caracteres.',
            'text_task_description.max' => 'O campo deve ter no máximo :max caracteres.',
        ];
    }
}
