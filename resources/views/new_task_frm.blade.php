<div id="newTaskModal"
    class="modal fixed inset-0 bg-neutral bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center"
    role="dialog" aria-modal="true" aria-labelledby="newTaskModalTitle" tabindex="-1">

    <div class="container mx-auto px-4 mt-5">
        <div class="w-full max-w-md mx-auto bg-neutral-medium rounded shadow-lg p-4 z-50">
            <h4 id="newTaskModalTitle" class="text-lg font-bold">Nova Tarefa</h4>
            <hr class="my-2">
            <form id="taskForm" class="modal-form" action="{{ route('new_task_submit') }}" method="post" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="text_task_name" class="form-label text-base font-medium">Nome da tarefa</label>
                    <input type="text" name="text_task_name" id="text_task_name"
                        class="form-input mt-1 block w-full rounded-md border-neutral shadow-sm"
                        placeholder="Nome da tarefa" required value="{{ old('text_task_name') }}">
                </div>

                <div class="mb-3">
                    <label for="text_task_description" class="form-label text-base font-medium">Descrição da
                        tarefa</label>
                    <textarea name="text_task_description" id="text_task_description"
                        class="form-textarea mt-1 block w-full rounded-md border-neutral shadow-sm" rows="5" required>{{ old('text_task_description') }}</textarea>
                </div>

                <div class="mb-3 text-center">
                    <button
                        class="modal-close-button inline-block bg-gray-400 text-white py-2 px-5 m-1 rounded hover:bg-gray-700">
                        <i class="bi bi-x-circle mr-2"></i>Cancelar
                    </button>
                    <button type="submit"
                        class="submit-button bg-blue-600 text-white py-2 px-5 m-1 rounded hover:bg-blue-800">
                        <i class="bi bi-save2 mr-2"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

