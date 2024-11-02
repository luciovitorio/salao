<!DOCTYPE html>
<html lang="en"
      class="h-full">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible"
              content="ie=edge">
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
        <title>Document</title>
    </head>

    <body class="h-full">
        <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
            <div class="text-center">
                <p class="text-5xl font-semibold text-indigo-600">404</p>
                <h1 class="mt-4 font-bold tracking-tight text-gray-900 text-3xl">
                    Página não encontrada
                </h1>
                <p class="mt-4 text-base leading-7 text-gray-600">
                    Desculpe, mais não podemos encontrar a página solicitada.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('dashboard') }}"
                       class="rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Voltar para o início
                    </a>
                </div>
            </div>
        </main>

    </body>

</html>
