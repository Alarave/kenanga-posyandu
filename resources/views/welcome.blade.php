<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Laravel Tailwind Hello World</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>

<body
    class="bg-neutral-50 dark:bg-neutral-900 text-primary-text font-primary min-h-screen flex items-center justify-center">
    <h1 class="text-primary-500 text-4xl font-semibold">Hello World</h1>
</body>

</html>
