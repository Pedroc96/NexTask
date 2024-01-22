<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('assets/styles.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @vite(['resources/css/app.css', 
    'resources/js/task_management.js',
     'resources/js/nav.js',
      'resources/js/search.js',
       'resources/js/nav_mobile.js',
       'resources/css/search.scss'])

</head>

<body class="flex min-h-dvh bg-slate-50" data-is-main-page="true">

       @include('nav.nav') 
 
       @include('nav.nav_mobile') 

    <main class="flex-1 overflow-y-auto p-6">
        
        @yield('content')

    </main>


</body>

</html>


