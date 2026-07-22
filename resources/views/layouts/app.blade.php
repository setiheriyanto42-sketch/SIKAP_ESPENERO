<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIKAP SMPN 2 JATIROTO</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        @include('layouts.partials.topbar')

        {{-- CONTENT --}}
        <main class="flex-1 p-6">

            @yield('content')

        </main>

        {{-- FOOTER --}}
        @include('layouts.partials.footer')

    </div>

</div>

</body>

</html>