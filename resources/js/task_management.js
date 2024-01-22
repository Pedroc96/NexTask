$(function () {
    init();

    // Função de inicialização
    function init() {
        setupAjax(); // Configura o Ajax
        initSortable(); // Inicializa a funcionalidade 'Sortable'
        setupEventListeners(); // Configura os ouvintes de eventos
    }
    // Função de inicialização
    function setupAjax() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

 // Inicializa a funcionalidade 'Sortable' para arrastar e soltar tarefas
    function initSortable() {
        $(".cards").sortable({
            connectWith: ".cards",
            items: ".card",
            placeholder: "ui-state-highlight",
            receive: function (event, ui) {
                let taskId = ui.item.data('id');
                let newStatus = ui.item.closest('.taskbox').data('status');
                updateTaskStatus(taskId, newStatus);
            }
        }).disableSelection();
    }

    // Configura os ouvintes de eventos para diversos elementos
    function setupEventListeners() {
        $(document).on('click', '.modal-trigger', handleModalTrigger)
        .on('click', '#open-modal-button, .open-modal-button', handleModalOpen)
        .on('click', '.edit-task-button', handleEditTask)
        .on('click', '.modal-close-button', handleCloseModal)
        .on('click', '.delete-task-button', handleDeleteTask)
        .on('click', '#deleteTaskModal .confirmDeleteButton', handleConfirmDelete)
    }

    function handleModalTrigger(event) {
        event.preventDefault();
        const url = $(this).data('url') || $(this).attr('href');
        const modalId = $(this).data('modal-id') || 'defaultModal';
        showModalWithContent(url, modalId);
    }

    function handleModalOpen(event) {
        event.preventDefault();
        showModalWithContent($(this).data('url'), $(this).data('modal-id'));
    }

    function handleEditTask(event) {
        event.preventDefault();
        showModalWithContent($(this).attr('href'), 'editTaskModal');
    }

    function handleCloseModal(event) {
        event.preventDefault();
        closeModal($(this).closest('.modal').attr('id'));
    }

    function handleDeleteTask(event) {
        event.preventDefault();
        showModalWithContent($(this).attr('href'), 'deleteTaskModal');
        $('#deleteTaskModal .confirmDeleteButton').data('delete-url', $(this).attr('href'));
    }

    function handleConfirmDelete() {
        performDelete($(this).data('delete-url'));
    }


    function openModal(modalId) {
        $('body').css('overflow', 'hidden');
        $(`#${modalId}`).removeClass('hidden');
    }

    function closeModal(modalId) {
        $('body').css('overflow', '');
        $(`#${modalId}`).addClass('hidden');
    }

    $(document).on('keydown', function(event) {
        if (event.key === "Escape") {
            closeModal('deleteTaskModal');
            closeModal('editTaskModal');
            closeModal('newTaskModal');
        }
    });
    
    


    function updateTaskStatus(taskId, newStatus) {
       
      
    
        $.ajax({
            url: `/tasks/${taskId}/update_status`,
            type: 'POST',
            data: {
                status: newStatus,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
             
    
                reloadTaskList();
                displaySuccessMessage('Status da tarefa atualizado com sucesso!');
            },
            error: function (xhr) {
             
    
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    displayErrorMessage(`Erro ao atualizar status da tarefa: ${xhr.responseJSON.message}`);
                } else {
                    displayErrorMessage('Erro ao atualizar status da tarefa.');
                }
            }
        });
    }
    
    
    async function showModalWithContent(url, modalId) {
        try {
            const response = await $.ajax({ type: 'GET', url: url });
            $(`#${modalId}`).remove();
            $('body').append(response);
            openModal(modalId);
        } catch (xhr) {
            displayErrorMessage(`Erro ao carregar modal: ${xhr.responseText}`);
        }
    }


    
    function displayValidationErrors(errors, formElement) {
        formElement.find('.error-message').remove();
        formElement.find('.is-invalid').removeClass('is-invalid');

        Object.keys(errors).forEach(field => {
            const inputField = formElement.find(`[name="${field}"]`);
            inputField.addClass('is-invalid');
            const errorMessage = errors[field].join(' ');
            inputField.after(`<div class="error-message text-red-500">${errorMessage}</div>`);
        });
    }


    async function performDelete(deleteUrl, taskId) {
        try {
            await $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') }
            });

            closeModal('deleteTaskModal');

            reloadTaskList()

            displaySuccessMessage('Tarefa excluída com sucesso!');

        } catch (xhr) {
            displayErrorMessage('Erro ao excluir a tarefa.');
        }
    }


    function submitForm(form, onSuccess, onError) {
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: new FormData(form[0]),
            contentType: false,
            processData: false,
        }).done(onSuccess).fail(onError);
    }

    function showLoadingIndicator(form) {
        
        form.find('.submit-button').prop('disabled', true).text('Carregando...');
    }
    
    function hideLoadingIndicator(form) {
        
        form.find('.submit-button').prop('disabled', false).text('Enviar');
    }
    

    
    $(document).on('submit', '.modal-form', function (e) {
        e.preventDefault();
        let form = $(this);
        let modalId = form.closest('.modal').attr('id');
    
        
        showLoadingIndicator(form);
    
        submitForm(form, function (response) {
            closeModal(modalId);
    
            reloadTaskList();

            displaySuccessMessage('Tarefa atualizada com sucesso!');
            
        }, function (xhr) {
         
            hideLoadingIndicator(form);
    
            if (xhr.status === 422) {
             
                displayValidationErrors(xhr.responseJSON.errors, form);
            } else {
           
                handleAjaxError(xhr);
            }
        });
    });


    function updateTaskCounters() {
        ['new', 'in_progress', 'completed'].forEach(status => {
            const count = $(`.taskbox[data-status=${status}] .card`).length;
            $(`.taskbox[data-status=${status}] .count`).text(count);
        });
    }


    function reloadTaskList() {
        $.ajax({
            url: '/updateUI',
            type: 'GET',
            success: function (taskBoxes) {
             
                $('.cards').empty();

       
                $.each(taskBoxes, function (status, tasks) {
                    tasks.forEach(task => {
                    
                        var taskHtml = ` <div class="card bg-gray-100 p-3 rounded-lg flex flex-col shadow-md hover:shadow-lg transition-shadow duration-300" data-id="${task.id}">
                                           <div class="flex justify-between">
                                               <h4 class="font-semibold text-gray-900 truncate">${task.name}</h4>
                                           </div>
                                               <p class="text-sm text-gray-600 break-words">${task.description}</p>
                                           <div class="mt-2 flex items-center justify-end space-x-2">
                                                ${task.edit_link}
                                   ${task.delete_link}
                           </div>
                       </div>`;
                      
                        $(`.taskbox[data-status="${status}"] .cards`).append(taskHtml);
                    });
                });

                updateTaskCounters();
            },
            error: function (xhr) {
                handleAjaxError(xhr);
            }
        });
    }


 

    function displaySuccessMessage(message) {
        Swal.fire({
            title: 'Sucesso!',
            text: message,
            icon: 'success',
            confirmButtonText: 'Ok',
            confirmButtonColor: '#2563EB'
        });
    }
    

   
    function displayErrorMessage(xhr) {
        let message = 'Ocorreu um erro. Tente novamente mais tarde.';
        if (xhr.status) {
            message += ` Erro ${xhr.status}: `;
        }
        if (xhr.responseJSON && xhr.responseJSON.message) {
            message += xhr.responseJSON.message;
        }
    
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: message,
            confirmButtonText: 'Ok',
            confirmButtonColor: '#2563EB'
        });
    }
    
    
    function handleAjaxError(xhr) {
        let errorMessage = 'Ocorreu um erro. Tente novamente mais tarde.';
        if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }
        displayErrorMessage(errorMessage);
    }


    

});
