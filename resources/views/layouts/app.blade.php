<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FileManager') }}</title>

    <!-- Styles -->
    <link href="/css/materialize.min.css" rel="stylesheet">
    <link href="/css/materialize-icon.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="application/octet-stream" type="text/css" href="{{ URL::asset('fonts/material-icons.woff2') }}">

    <!-- Scripts -->
    <script>
        window.Laravel = {!!
            json_encode([
                 'csrfToken' => csrf_token(),
             ]);
        !!}
    </script>
</head>
<body>
    <div id="app">
        @include('controls.main-nav')
        @if (!Auth::guest())

            @include('controls.sidebar')
            <!-- Modal Structure -->
            @include('controls.create-folder')
            <div class="home-page-container">
                @yield('content')
            </div>
        @else
        @yield('content')
        @endif
    </div>
    <!-- Scripts -->
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/materialize.min.js"></script>
    <script src="/js/app.js"></script>
    @yield('scripts')
    <script>
        @if (session('status'))
            Materialize.toast("{{ session('status') }}", 4000, 'green darken-4');
        @endif
        @if (session('alert-success'))
            Materialize.toast("{{ session('alert-success') }}", 4000, 'green darken-4');
        @endif
    </script>
</body>
</html>
