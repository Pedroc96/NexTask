<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use App\Models\TaskModel;
use Illuminate\Support\Facades\Log;	

class TaskUpdateRequest extends FormRequest
{
    protected $decryptedTaskId;

    public function authorize()
    {
        try {
            $this->decryptedTaskId = Crypt::decrypt($this->input('task_id'));
            $task = TaskModel::find($this->decryptedTaskId);
            return $task && $this->user()->id == $task->id_user;
        } catch (\Exception $e) {
            Log::error('Erro na autorização: ' . $e->getMessage());
            return false;
        }
    }

    public function rules()
    {
        return [
            'text_task_name' => [
                'required',
                'min:3',
                'max:200',
                'unique:tasks,task_name,' . $this->decryptedTaskId,
            ],
            'text_task_description' => 'required|min:3|max:1000',
            'text_task_status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'text_task_name.required' => 'O campo nome da tarefa é obrigatório.',
            'text_task_name.min' => 'O nome da tarefa deve ter pelo menos :min caracteres.',
            'text_task_name.max' => 'O nome da tarefa não pode ter mais de :max caracteres.',
            'text_task_name.unique' => 'Já existe uma tarefa com este nome.',
            'text_task_description.required' => 'O campo descrição da tarefa é obrigatório.',
            'text_task_description.min' => 'A descrição da tarefa deve ter pelo menos :min caracteres.',
            'text_task_description.max' => 'A descrição da tarefa não pode ter mais de :max caracteres.',
            'text_task_status.required' => 'O campo status da tarefa é obrigatório.',
          
        ];
    }
}
