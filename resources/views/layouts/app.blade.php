<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
   	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>@yield('title', 'Tarefa solicitada')</title>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="antialiased">
@navbar(\App\View\Components\BarraNavegacao::class)
	<div class="container">
        @yield('content')
    </div>
<script>
@stack('jscode')
</script>
</body>
</html>