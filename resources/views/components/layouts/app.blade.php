<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="h-full bg-gray-100">

    <head>
        <meta charset="utf-8">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0">
        {{-- Fonte Poppins --}}
        <link rel="preconnect"
              href="https://fonts.googleapis.com">
        <link rel="preconnect"
              href="https://fonts.gstatic.com"
              crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
              rel="stylesheet">
        {{-- Tallstack --}}
        <tallstackui:script />
        {{-- Tailwind --}}
        @vite('resources/css/app.css')

        <title>{{ $title ?? 'Page Title' }}</title>
    </head>

    <body class="h-full">
        <x-dialog />
        <x-toast />
        <div class="min-h-full">
            <livewire:dashboard.header-component />
            <x-header title="{{ $title ?? 'Default title' }}" />
            <main>
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                    <x-footer />
                </div>
            </main>
        </div>
    </body>

</html>
