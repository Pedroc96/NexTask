@extends('templates.login_layout')

@section('content')
<article class="flex flex-col min-h-screen bg-gray-50">
    <header class="w-full p-4 flex items-center justify-start">
        <div class="flex items-center space-x-3"> 
            <img src="{{ asset('assets/img/NexTask.png') }}" alt="NexTask Logo" class="h-12">
            <h1 class="text-3xl font-bold text-gray-800">NexTask</h1>
        </div>
    </header>

        <section class="flex items-center justify-center flex-grow">
            <div class="w-full px-4 sm:px-0">
                <div class="mx-auto bg-white
                rounded-lg shadow-lg p-8 max-w-xs sm:max-w-sm md:max-w-md">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Login</h1>

                    <form action="{{ route('login_submit') }}" method="post" class="space-y-6">
                        @csrf

                        <div>
                            <label for="text_username" class="block text-gray-700 font-semibold mb-2">Username</label>
                            <input type="text" name="text_username" id="text_username"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Insira o seu username" required autocomplete="username"
                                value="{{ old('text_username') }}">
                            @error('text_username')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="text_password" class="block text-gray-700 font-semibold mb-2">Senha</label>
                            <input type="password" name="text_password" id="text_password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Insira a sua password" required autocomplete="current-password">
                            @error('text_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="w-full px-4 py-2 text-white bg-green rounded-md hover:bg-green-dark focus:outline-none focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                Login
                            </button>
                        </div>
                     

                    @if (session('login_error'))
                        <div class="mt-4 p-2 text-center text-sm text-red-700 bg-red-200 rounded-md">
                            {{ session('login_error') }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </article>
@endsection
