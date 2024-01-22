$(function () {
    // Variáveis globais para reutilização de seletores
    const $window = $(window);
    const $document = $(document);
    const $body = $('body');
    const $searchBoxes = $('.search-box');
    const $taskBoxes = $(".taskbox");
    const $searchBoxContainer = $('#search-box-container');
    const $searchButton = $('#search-button');
    const breakpoint = 768;
    let isSearchBoxManuallyHidden = false;
    let debounceTimeout;

    // Funções de inicialização
    function init() {
        setupEventListeners();
        adjustSearchBoxVisibility();
    }

    function setupEventListeners() {
        $window.on('resize', adjustSearchBoxVisibility);
        $searchButton.on('click', toggleSearchBox);
        $document.on('click', outsideClickHandler);
        $searchBoxes.on('keyup', searchBoxKeyupHandler);
    }

    // Função de manipulação de evento
    function toggleSearchBox() {
        $searchBoxContainer.toggle();
        isSearchBoxManuallyHidden = $searchBoxContainer.is(':hidden');
        if (isSearchBoxManuallyHidden) {
            $searchBoxes.val('');
        }
    }

    function adjustSearchBoxVisibility() {
        if ($window.width() < breakpoint) {
            $searchBoxContainer.hide();
            isSearchBoxManuallyHidden = true;
        } else if (!isSearchBoxManuallyHidden) {
            $searchBoxContainer.show();
        }
    }

    function outsideClickHandler(event) {
        if (!$searchBoxContainer.is(event.target) && !$searchButton.is(event.target) && $searchBoxContainer.has(event.target).length === 0) {
            $searchBoxContainer.hide();
            isSearchBoxManuallyHidden = true;
            $searchBoxes.val('');
        }
    }

    function searchBoxKeyupHandler() {
        clearTimeout(debounceTimeout);
        let searchTerm = $(this).val().trim();
        debounceTimeout = setTimeout(() => {
            loadTasks(searchTerm);
        }, 500);
    }

    function loadTasks(searchTerm) {
        let requestData = searchTerm.length === 0 ? {} : { text_search: searchTerm };

        $.ajax({
            url: '/search',
            type: 'GET',
            dataType: 'json',
            data: requestData,
            success: function (response) {
                $taskBoxes.find('.cards').empty();

                $.each(response, function (status, tasks) {
                    let $currentBox = $(".taskbox[data-status='" + status + "']").find('.cards');

                    tasks.forEach(task => {
                        let taskHtml = `
                            <div class="card bg-gray-100 p-3 rounded flex flex-col shadow-sm truncate" data-id="${task.id}">
                                <h4 class="font-semibold">${task.name}</h4>
                                <p class="text-sm text-gray-600">${task.description}</p>
                                <div class="mt-2 flex justify-end space-x-2">
                                    ${task.edit_link}
                                    ${task.delete_link}
                                </div>
                            </div>`;
                        $currentBox.append(taskHtml);
                    });
                });
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Pesquisa falhou: ' + textStatus + '. ' + errorThrown + '. Tente Novamente.');
            }
        });
    }

  
    init();
});
