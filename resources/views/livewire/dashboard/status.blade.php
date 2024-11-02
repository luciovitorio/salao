<div>
    <?php
    setlocale(LC_TIME, 'pt_BR.UTF-8'); // Define a localidade para português do Brasil
    ?>
    <h3 class="text-base font-semibold leading-6 text-gray-900">
        {{ ucfirst(\Carbon\Carbon::now()->locale('pt_BR')->translatedFormat('F')) }}
    </h3>

    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <svg class="h-6 w-6 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">
                    Total de serviços realizados
                </p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">
                    {{ $servicosMesAtual }}
                </p>
                @if ($diferencaServicos > 0)
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                        <x-icon name="arrow-trending-up"
                                class="h-5 w-5 text-green-500" />
                        {{ $diferencaServicos }}
                    </p>
                @elseif($diferencaServicos < 0)
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">
                        <x-icon name="arrow-trending-down"
                                class="h-5 w-5 text-red-500" />
                        {{ $diferencaServicos }}
                    </p>
                @else
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                        -
                        {{ $diferencaServicos }}
                    </p>
                @endif

                <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('services') }}"
                           wire:navigate
                           class="font-medium text-indigo-600 hover:text-indigo-500">
                            Ver todos
                        </a>
                    </div>
                </div>
            </dd>
        </div>
        <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
            <dt>
                <div class="absolute rounded-md bg-green-500 p-3">
                    <svg class="h-6 w-6 text-white"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="size-6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">
                    Total de entradas
                </p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">
                    R$ {{ number_format($entradasMesAtual, 2, ',', '.') }}
                </p>
                @if ($percentualDiferencaEntradas > 0)
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                        <x-icon name="arrow-trending-up"
                                class="h-5 w-5 text-green-500" />
                        {{ number_format($percentualDiferencaEntradas, 2, ',', '.') }}%
                    </p>
                @elseif($percentualDiferencaEntradas < 0)
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">
                        <x-icon name="arrow-trending-down"
                                class="h-5 w-5 text-red-500" />
                        {{ number_format($percentualDiferencaEntradas, 2, ',', '.') }}%
                    </p>
                @else
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                        -
                        {{ number_format($percentualDiferencaEntradas, 2, ',', '.') }}%
                    </p>
                @endif

                <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('reports') }}"
                           class="font-medium text-indigo-600 hover:text-indigo-500">
                            Relatório
                        </a>
                    </div>
                </div>
            </dd>
        </div>
        <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
            <dt>
                <div class="absolute rounded-md bg-red-500 p-3">
                    <svg class="h-6 w-6 text-white"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="size-6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">
                    Total de saída
                </p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">
                    R$ {{ number_format($saidasMesAtual, 2, ',', '.') }}
                </p>
                @if ($percentualDiferencaSaidas > 0)
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                        <x-icon name="arrow-trending-up"
                                class="h-5 w-5 text-green-500" />
                        {{ number_format($percentualDiferencaSaidas, 2, ',', '.') }}%
                    </p>
                @elseif($percentualDiferencaEntradas < 0)
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">
                        <x-icon name="arrow-trending-down"
                                class="h-5 w-5 text-red-500" />
                        {{ number_format($percentualDiferencaSaidas, 2, ',', '.') }}%
                    </p>
                @else
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                        -
                        {{ number_format($percentualDiferencaSaidas, 2, ',', '.') }}%
                    </p>
                @endif
                </p>
                <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('expenses') }}"
                           class="font-medium text-indigo-600 hover:text-indigo-500">
                            Ver todos
                        </a>
                    </div>
                </div>
            </dd>
        </div>
    </dl>
</div>
