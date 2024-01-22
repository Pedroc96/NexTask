<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use App\Models\UserModel;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\EditTaskRequest;
use App\Http\Requests\LoginTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;




class Main extends Controller
{

    // Página principal

    public function index(TaskModel $taskModel, Request $request)
    {

        $userId = Auth::id();


        if (!Auth::check()) {
            return redirect()->route('login');
        } 
       

        $tasks = $taskModel->where('id_user', '=', $userId)
            ->whereNull('deleted_at')
            ->get();

        $data['taskBoxes'] = $this->get_tasks($tasks);


        return view('main', [
            'title' => 'NexTask',
            'taskBoxes' => $data['taskBoxes']
        ]);
       
    }


    // Login

    public function login()
    {
        $data = ['title' => 'Login | NexTask'];
        return view('login_frm', $data);
    }



    public function login_submit(LoginTaskRequest $request)
    {
        $credentials = [
            'username' => $request->input('text_username'),
            'password' => $request->input('text_password')
        ];

        if (Auth::attempt($credentials, true)) {
            return redirect()->route('index');
        }

        return redirect()
            ->route('login')
            ->withInput()
            ->with('login_error', 'Credenciais de login inválidas');
    }


    // Logout

    public function logout()
    {
        
        Auth::logout();

        return redirect()->route('login');
    }

    // Nova tarefa

    public function new_task()
    {
       
        $data = [
            'title' => 'Nova Tarefa | TaskTrek'
        ];

     
        return view('new_task_frm', $data);
    }

    public function new_task_submit(CreateTaskRequest $request)
    {
        
        try {
            // Criar uma nova entrada de tarefa no banco de dados com os dados fornecidos.
            TaskModel::create([
                'id_user' => Auth::id(),
                'task_name' => $request->input('text_task_name'),
                'task_description' => $request->input('text_task_description'),
                'task_status' => 'new'
            ]);

            // Mensagem de sucesso em caso de criação bem-sucedida da tarefa.
            $message = ['success' => 'Tarefa criada com sucesso.'];

            // Verificar se a solicitação é uma chamada AJAX e retornar JSON, ou redirecionar para a página principal com a mensagem.
            return $request->ajax()
                ? response()->json($message)
                : redirect()->route('index')->with($message);
        } catch (\Exception $e) {
            // Registar um erro em caso de falha na criação da tarefa.
            Log::error("Erro ao criar tarefa: {$e->getMessage()}", [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            // Mensagem de erro em caso de falha na criação da tarefa.
            $errorMessage = ['error' => 'Erro ao criar tarefa. Por favor, tente novamente.'];

            // Verificar se a solicitação é uma chamada AJAX e retornar JSON de erro, ou redirecionar para a página principal com mensagem de erro.
            return $request->ajax()
                ? response()->json($errorMessage, 500)
                : redirect()->route('index')->withErrors($errorMessage);
        }
        
    }



    // Editar tarefa
    public function edit_task($encrypted_id)
    {
        try {
            // Tentar desencriptar o ID da tarefa a partir do parâmetro $encrypted_id
            $id = Crypt::decrypt($encrypted_id);
        } catch (DecryptException $e) {
            // Registar a exceção específica de desencriptação e redirecionar com uma mensagem de erro
            Log::error("Falha ao desencriptar o ID da tarefa: {$encrypted_id}", [$e]);
            return redirect()->route('index')->with('error', 'Erro ao aceder aos dados da tarefa.');
        } catch (\Exception $e) {
            // Registar outras exceções gerais e redirecionar com uma mensagem de erro
            Log::error("Erro genérico ao processar o ID da tarefa: {$encrypted_id}", [$e]);
            return redirect()->route('index')->with('error', 'Erro ao processar o pedido.');
        }

        // Obter os dados da tarefa
        $task = TaskModel::find($id);

        // Verificar se a tarefa existe
        if (!$task) {
            return redirect()->route('index')->with('error', 'Tarefa não encontrada.');
        }


        return view('edit_task_frm', ['title' => 'Editar Tarefa ', 'task' => $task]);
    }


    public function edit_task_submit(EditTaskRequest $request)
    {

        $validatedData = $request->validated();

        try {
            // Tentar desencriptar o ID da tarefa a partir do input 'task_id'
            $id_task = Crypt::decrypt($request->input('task_id'));
        } catch (\Exception $e) {
            // Registar a exceção e redirecionar com uma mensagem de erro
            Log::error("Falha ao desencriptar o ID da tarefa: {$request->input('task_id')}", [$e]);
            return redirect()->route('index')->with('error', 'Erro ao atualizar a tarefa.');
        }

        // Encontra a tarefa e verificar se pertence ao utilizador autenticado
        $task = TaskModel::find($id_task);
        if ($task && $task->id_user == Auth::id()) {
            // Atualizar a tarefa com os dados validados
            $task->update([
                'task_name' => $validatedData['text_task_name'],
                'task_description' => $validatedData['text_task_description'],
                'task_status' => $validatedData['text_task_status'],
            ]);
            return redirect()->route('index')->with('success', 'Tarefa atualizada com sucesso.');
        }

        // Redirecionar com mensagem de erro se a tarefa não existir ou não pertencer ao utilizador
        return redirect()->route('index')->with('error', 'Erro ao atualizar a tarefa ou a tarefa não pertence ao utilizador.');
    }



    // Eliminar tarefa

    public function delete_task($encrypted_id)
    {
        try {
            // Tenta decifrar o ID da tarefa a partir do valor encriptado
            $id = Crypt::decrypt($encrypted_id);
        } catch (\Exception $e) {
            // Registar o erro e retornar uma resposta JSON com mensagem de erro
            Log::error("Erro ao decifrar o ID da tarefa: {$encrypted_id}", [$e]);
            return response()->json(['error' => 'Erro ao decifrar o ID da tarefa.'], 400);
        }

        // Procurar a tarefa pelo ID
        $task = TaskModel::find($id);

        if (!$task) {
            // Se a tarefa não for encontrada, retorna um erro 404
            return response()->json(['error' => 'Tarefa não encontrada.'], 404);
        }

        // Retornar a view para confirmar a exclusão da tarefa
        return view('delete_task', ['task' => $task]);
    }

    public function delete_task_confirm($encrypted_id)
    {
        try {
            // Tenta decifrar o ID da tarefa a partir do valor encriptado
            $id_task = Crypt::decrypt($encrypted_id);
        } catch (\Exception $e) {
            // Registar o erro e retornar uma resposta JSON com mensagem de erro
            Log::error("Erro ao decifrar o ID da tarefa: {$encrypted_id}", [$e]);
            return response()->json(['error' => 'Erro ao decifrar o ID da tarefa.'], 400);
        }

        // Procurar a tarefa pelo ID
        $task = TaskModel::find($id_task);

        if (!$task) {
            // Se a tarefa não for encontrada, retorna um erro 404
            return response()->json(['error' => 'Tarefa não encontrada.'], 404);
        }

        // Tentar excluir a tarefa
        try {
            $task->delete();
            // Se a tarefa for excluída com sucesso, retornar uma resposta de sucesso
            return response()->json(['success' => 'Tarefa excluída com sucesso.']);
        } catch (\Exception $e) {
            // Registar o erro e retornar uma resposta de erro
            Log::error("Erro ao excluir a tarefa: ID {$id_task}", [$e]);
            return response()->json(['error' => 'Erro ao excluir a tarefa.'], 500);
        }
    }


    public function updateTaskStatus($id, Request $request)
    {
        // Validação do estado da tarefa
        $validatedData = $request->validate([
            'status' => ['required', Rule::in(['new', 'in_progress', 'completed'])],
        ]);

        // Procurar a tarefa pelo ID
        $task = TaskModel::find($id);

        if (!$task) {
            return response()->json(['error' => 'Tarefa não encontrada'], 404);
        }

        // Verificação adicional para garantir que a tarefa pertence ao utilizador autenticado
        if ($task->id_user != Auth::id()) {
            return response()->json(['error' => 'Acesso não autorizado à tarefa'], 403);
        }

        // Atualizar o estado da tarefa
        $task->task_status = $validatedData['status'];
        $task->save();

        return response()->json(['message' => 'Estado da tarefa atualizado com sucesso']);
    }



    public function updateUI()
    {
        $userId = Auth::id();

        if (!$userId) {
            // Retornar erro ou redirecionar se o utilizador não estiver autenticado
            return response()->json(['error' => 'Utiliazador não autenticado'], 403);
        }

        // Obter as tarefas do utilizador autenticado que não foram excluídas
        $tasks = TaskModel::where('id_user', $userId)
            ->whereNull('deleted_at')
            ->get();

        // Formatar as tarefas em caixas (taskBoxes)
        $taskBoxes = $this->get_tasks($tasks);

        return response()->json($taskBoxes);
    }



    public function search(Request $request)
    {
        // Validação: permitir termo de pesquisa vazio
        $request->validate(['text_search' => 'nullable|string|max:255']);

        // Obter o termo de pesquisa do pedido
        $searchTerm = $request->text_search;

        // Construir a consulta de pesquisa
        $tasksQuery = TaskModel::where('id_user', Auth::id()); 

        if (!empty($searchTerm)) {
            $tasksQuery->where(function ($query) use ($searchTerm) {
                // Procurar pelas iniciais no nome e na descrição da tarefa
                $query->where('task_name', 'like', $searchTerm . '%')
                    ->orWhere('task_description', 'like', $searchTerm . '%');
            });
        }

        // Executar a consulta e obter os resultados
        $tasks = $tasksQuery->get(); // Obter todas as tarefas correspondentes

        // Utilizar a função getTasks para formatar as tarefas encontradas
        return response()->json($this->get_tasks($tasks));
    }



    // Métodos privados

    private function get_tasks($tasks)
    {
        // Inicializar arrays vazios para cada estado de tarefa
        $taskBoxes = [
            'new' => [],
            'in_progress' => [],
            'completed' => []
        ];

        // Iterar sobre as tarefas e formatá-las para exibição
        foreach ($tasks as $task) {
            // Criar links para editar e excluir a tarefa
            $link_edit = '<a href="' . route('edit_task', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1 edit-task-button"><i class="bi bi-pencil-square"></i></a>';
            $link_delete = '<a href="' . route('delete_task', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1 delete-task-button"><i class="bi bi-trash"></i></a>';

            // Formatar a tarefa em um array com informações relevantes
            $formattedTask = [
                'id' => $task->id,
                'name' => $task->task_name,
                'description' => $task->task_description,
                'status' => $task->task_status,
                'edit_link' => $link_edit,
                'delete_link' => $link_delete
            ];

            // Adicionar a tarefa à caixa apropriada com base no estado
            $taskBoxes[$task->task_status][] = $formattedTask;
        }

        return $taskBoxes;
    }
}
