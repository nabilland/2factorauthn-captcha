<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>
    <body>
        <main>
            @include('layouts.header-ip')
            @yield('container')
        </main>
        <footer>
            @include('layouts.footer-ip')
        </footer>
    </body>
</html>