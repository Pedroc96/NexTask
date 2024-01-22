<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/styles.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        green: {
                            dark: '#003d57',
                            DEFAULT: '#01b3a6',
                            light: '#6EE7B7',
                        }
                    }

                }
            }
        }
    </script>
</head>

<body>

    @yield('content')


</body>

</html>
