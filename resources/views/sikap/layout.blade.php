<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKAP ESPENERO</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    @include('sikap.header')

    <div class="flex min-h-screen">

        @include('sikap.sidebar')

        <main class="flex-1 p-6">

            {{ $slot }}

        </main>

    </div>

    @include('sikap.footer')

</body>
</html>
