<nav
    class="md:hidden flex items-center justify-end bg-neutral-medium text-neutral-darkest p-4 fixed inset-x-0 top-0 z-50 overflow-hidden shadow">

    <div class="flex space-x-2">

        <button aria-label="Open new task modal" class="open-modal-button p-2 focus:outline-none"
            data-modal-id="newTaskModal" data-url="{{ route('new_task') }}">
            <i class="bi bi-plus-square"></i>
        </button>

        <div class="container">
            <button id="openSearchModalMob" aria-label="Open search modal" class="p-2 focus:outline-none">
                <i class="search"></i>
            </button>
        </div>

        <div class="search-container">
            <input id="search-box" type="text" class="search-box" name="text_search"
                placeholder="Pesquisar tarefas..." required />
            <label for="search-box"><i class="bi bi-search search-icon"></i></label>
        </div>


    </div>


    <button class="menu-button p-4 ml-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>


</nav>

<ul id="menuList" class="hidden absolute right-0.5 top-24 p-2 border bg-white shadow-lg z-50">

    <li class="flex items-center space-x-3 py-2 px-4">

        <div id="userInitialsMobile" data-username="{{ Auth::user()->username }}"
            class="user-initials h-12 w-12 rounded-full"></div>

        <span class="text-neutral-darkest truncate">
            <strong>{{ Auth::user()->username }}</strong>
        </span>
    </li>

    <li>
        <a href="{{ route('logout') }}" class="block py-2 px-8 text-neutral-darkest hover:bg-neutral-light">
            <i class="bi bi-box-arrow-right"></i> Sair
        </a>
    </li>
</ul>
