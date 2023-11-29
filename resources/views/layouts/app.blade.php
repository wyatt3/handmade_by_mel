<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>

    <div id="app">
        @include('partials.navbar')

        @yield('content')

        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-tertiary">Copyright &copy; {{ config('app.name') }} {{ date('Y') }}</p>
            </div>
        </footer>
    </div>
</body>

</html>