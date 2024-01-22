<aside id="Nav"
    class="hidden md:flex md:flex-col md:w-64 bg-neutral-light overflow-y-auto py-7 px-4 transition-transform duration-300">

    <header class="flex flex-col items-center mt-10">

        <div id="userInitialsDesktop" data-username="{{ Auth::user()->username }}"
            class="user-initials h-12 w-12 rounded-full"></div>

        <h2 class="text-lg font-semibold">{{ Auth::user()->username }}</h2>

    </header>

    <nav class="mt-10" role="navigation">
        <ul class="space-y-2">
            <li>
                <button id="open-modal-button" data-modal-id="newTaskModal" data-url="{{ route('new_task') }}"
                    class=" block w-full text-left rounded py-2 px-4 text-neutral-darkest hover:bg-neutral-mediumLight transition duration-300 cursor-pointer">
                    <i class="bi bi-plus-square mr-2"></i>Nova tarefa
                </button>
            </li>
            <li>
                <button id="search-button" aria-label="Open search modal"
                    class="block w-full text-left rounded py-2 px-4 text-neutral-darkest hover:bg-neutral-mediumLight transition duration-300 cursor-pointer">
                    <i class="bi bi-search mr-1"></i> Pesquisar
                </button>
            </li>
        </ul>
    </nav>

</aside>
