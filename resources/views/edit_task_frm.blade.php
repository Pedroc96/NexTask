<div id="editTaskModal"
    class="modal  fixed inset-0 bg-gray-600 bg-opacity-50 z-50 overflow-y-auto h-full w-full flex items-center justify-center" aria-modal="true" role="dialog" aria-labelledby="modalTitle">
    <div class="container mx-auto px-4 mt-5">
        <div class="container mx-auto px-4 mt-5">
            <div class="w-full max-w-md mx-auto bg-neutral-medium rounded shadow-lg p-4 z-50">

                <h4 id="modalTitle">Editar Tarefa</h4>

                <hr class="my-2">

                <form id="editTaskForm" class="modal-form" action="{{ route('edit_task_submit') }}" method="post">

                    @csrf
                    <input type="hidden" name="task_id" value="{{ Crypt::encrypt($task->id) }}" />

                    {{-- task name --}}
                    <div class="mb-3">
                        <label for="text_task_name" class="block text-sm font-medium text-neutral">Nome da
                            tarefa</label>
                        <input type="text" name="text_task_name" id="text_task_name"
                            class="form-input mt-1 block w-full rounded-md border-neutral shadow-sm"
                            placeholder="Nome da tarefa" required value="{{ old('text_task_name', $task->task_name) }}">

                    </div>


                    <div class="mb-3">
                        <label for="text_task_description" class="block text-sm font-medium text-gray-700">Descrição da
                            tarefa</label>
                        <textarea name="text_task_description" id="text_task_description"
                            class="form-textarea mt-1 block w-full rounded-md border-neutral shadow-sm" rows="5" required>{{ old('text_task_description', $task->task_description) }}</textarea>
                    </div>


                    <div class="mb-3">
                        <label for="select_task_status" class="block text-sm font-medium text-gray-700">Estado da
                            tarefa</label>
                        <select name="text_task_status" id="text_task_status"
                            class="form-select mt-1 block w-1/4 rounded-md border-gray-300 shadow-sm" required>
                            <option value="new"
                                {{ old('text_task_status', $task->task_status) == 'new' ? 'selected' : '' }}>Nova
                            </option>
                            <option value="in_progress"
                                {{ old('text_task_status', $task->task_status) == 'in_progress' ? 'selected' : '' }}>Em
                                Andamento</option>
                            <option value="completed"
                                {{ old('text_task_status', $task->task_status) == 'completed' ? 'selected' : '' }}>
                                Concluída
                            </option>
                        </select>
                    </div>


                    <div class="mb-3 text-center">
                        <button
                            class="modal-close-button inline-block bg-gray-400 text-white py-2 px-5 m-1 rounded hover:bg-gray-700">
                            <i class="bi bi-x-circle mr-2"></i>Cancelar
                        </button>
                        <button type="submit"
                            class="submit-button bg-blue-600 text-white py-2 px-5 m-1 rounded hover:bg-blue-900 ">
                            <i class="bi bi-floppy mr-2"></i>Atualizar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

