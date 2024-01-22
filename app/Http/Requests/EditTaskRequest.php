<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class EditTaskRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    protected function prepareForValidation()
    {
        try {
            $decryptedId = Crypt::decrypt($this->input('task_id'));
            $this->merge(['decrypted_task_id' => $decryptedId]);
        } catch (\Exception $e) {
            Log::error("Erro ao descriptografar task_id: " . $e->getMessage());
            abort(422, "Erro ao processar o ID da tarefa.");
        }
    }

    public function rules()
    {
        return [
            'text_task_name' => [
                'required',
                'min:3',
                'max:200',
                Rule::unique('tasks', 'task_name')->ignore($this->decrypted_task_id),
            ],
            'text_task_description' => 'required|min:3|max:1000',
            'text_task_status' => [
                'required',
                Rule::in(['new', 'in_progress', 'completed']),
            ],
        ];
    }

    public function messages()
    {
        return [
            'text_task_name.required' => 'O nome da tarefa é obrigatório.',
            'text_task_name.min' => 'O nome da tarefa deve ter no mínimo 3 caracteres.',
            'text_task_name.max' => 'O nome da tarefa deve ter no máximo 200 caracteres.',
            'text_task_name.unique' => 'Já existe uma tarefa com este nome.',
            'text_task_description.required' => 'A descrição da tarefa é obrigatória.',
            'text_task_description.min' => 'A descrição da tarefa deve ter no mínimo 3 caracteres.',
            'text_task_description.max' => 'A descrição da tarefa deve ter no máximo 1000 caracteres.',
            'text_task_status.required' => 'O status da tarefa é obrigatório.',
            'text_task_status.in' => 'O status da tarefa não é válido.',
        ];
    }
}
