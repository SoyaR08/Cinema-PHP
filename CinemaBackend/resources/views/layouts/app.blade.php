<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title')</title>
</head>

<body>
    <x-header />

    @yield('content')

    <footer class="container text-center my-4">
        <div style="height: 1px; width: auto; background-color:black;"></div>
        <p class="copyright text-center">&copy; 2026. Todos los derechos reservados.</p>
    </footer>
</body>

</html>