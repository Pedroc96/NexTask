<div id="deleteTaskModal"
    class="modal fixed inset-0 bg-gray-600 bg-opacity-50 z-50 overflow-y-auto h-full w-full flex items-center justify-center" aria-labelledby="modalTitle" aria-describedby="modalDescription" role="dialog" aria-modal="true">

    <div class="bg-white rounded-lg shadow-lg w-11/12 sm:w-1/2 md:max-w-md mx-auto p-4 relative">
         <h4 id="modalTitle" class="text-lg font-bold break-words">Excluir Tarefa</h4>
        <hr class="my-2">
       
        <p id="modalDescription" class="text-gray-500 break-words">{{ $task->task_description }}</p>

        <p class="my-5 text-center">Deseja excluir esta tarefa?</p>

        <div class="flex justify-center">
            <button class="modal-close-button inline-block bg-gray-400 text-white py-2 px-5 m-1 rounded hover:bg-gray-700">
                <i class="bi bi-x-circle mr-2"></i>Cancelar
            </button>
            <button
                class="confirmDeleteButton bg-red-600 text-white py-2 px-5 m-1 rounded hover:bg-red-700 transition duration-300 confirmDeleteButton"
                data-delete-url="{{ route('delete_task_confirm', ['id' => Crypt::encrypt($task->id)]) }}">
                <i class="bi bi-trash mr-2"></i>Excluir
            </button>
        </div>
    </div>
</div>
