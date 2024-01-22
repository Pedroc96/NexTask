@extends('templates/main_layout')

@section('content')
    <div class="w-full flex justify-end">
        <div class="mb-6 px-4 pb-2 md:block hidden">
            <a href="{{ route('logout') }}"
                class="inline-block text-center text-white bg-red-crayola py-2 px-4 rounded hover:bg-alert transition duration-300">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>
    </div>

    <div class="flex justify-center my-10">
        <div id="search-box-container" style="display: none;">

            <input type="text" id="search-box" class="search-box" name="text_search" placeholder="Pesquisar tarefas..." />
            <label for="search-box" class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </label>

        </div>

    </div>


    <div class="container mx-auto px-4 lg:px-20 mb-3 mt-12 md:mt-0">
        <div class="outer-wrap">
            <div class="inner-wrap grid grid-cols-1 md:grid-cols-3 gap-3 p-3">
                @php
                    $statuses = [
                        'new' => 'Nova',
                        'in_progress' => 'Em Progresso',
                        'completed' => 'Concluída',
                    ];
                @endphp

                @foreach ($statuses as $statusKey => $statusTitle)
                    <div class="taskbox bg-white rounded-lg shadow h-auto min-h-96 p-4 flex flex-col"
                        data-status="{{ $statusKey }}">

                        <div class="title flex justify-between items-start mb-4">
                            <p class="font-bold text-lg text-gray-700 truncate">{{ $statusTitle }}</p>
                            <span
                                class="count bg-blue-100 text-blue-800 text-sm font-semibold mr-3 px-2.5 py-0.5 rounded-full">
                                {{ count($taskBoxes[$statusKey] ?? []) }}
                            </span>
                        </div>

                        <div class="cards space-y-2 overflow-auto flex-grow">
                            @foreach ($taskBoxes[$statusKey] ?? [] as $task)
                                <div class="card bg-gray-100 p-3 rounded-lg flex flex-col shadow transition-shadow duration-200 ease-in-out hover:shadow-md"
                                    data-id="{{ $task['id'] }}">
                                    <h4 class="font-semibold truncate w-full text-gray-800">{{ $task['name'] }}</h4>
                                    <p class="text-sm text-gray-600 break-words">{{ $task['description'] }}</p>
                                    <div class="mt-2 flex justify-end space-x-2">
                                        {!! $task['edit_link'] !!}
                                        {!! $task['delete_link'] !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
