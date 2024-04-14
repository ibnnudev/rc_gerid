<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('assets/application/logo mini.jpeg') }}">

    @if (request()->routeIs('login') ||
            request()->routeIs('register') ||
            request()->routeIs('password.request') ||
            request()->routeIs('password.reset') ||
            request()->routeIs('password.email') ||
            request()->routeIs('password.update') ||
            request()->routeIs('password.confirm') ||
            request()->routeIs('verification.notice') ||
            request()->routeIs('verification.verify') ||
            request()->routeIs('verification.resend'))
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
            rel="stylesheet">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Alert -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @stack('css-internal')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    @if (request()->routeIs('login') ||
            request()->routeIs('register') ||
            request()->routeIs('password.request') ||
            request()->routeIs('password.reset') ||
            request()->routeIs('password.email') ||
            request()->routeIs('password.update') ||
            request()->routeIs('password.confirm') ||
            request()->routeIs('verification.notice') ||
            request()->routeIs('verification.verify') ||
            request()->routeIs('verification.resend'))
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 pb-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <img src="{{ asset('assets/application/logo.jpeg') }}" width="400" alt=""
                        class="mix-blend-multiply">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    @else
        @include('layouts.guest-header')
        <div class="min-h-screen bg-[#f2f2f2]">
            <div class="px-8 py-12 mx-auto max-w-7xl">
                {{ $slot }}
            </div>
        </div>
        @include('layouts.guest-footer')
    @endif

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>

    @stack('js-internal')
</body>

</html>
