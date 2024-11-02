<div>
    <x-button icon="arrow-left"
              position="left"
              class="mb-2"
              outline
              sm
              href="{{ route('reports') }}"
              wire:navigate>
        Voltar
    </x-button>
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
        <form wire:submit.prevent="generateReport">
            <div class="space-y-6">
                <div class="border-b border-gray-900/10 pb-6">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">
                        Relatório de serviços
                    </h2>
                </div>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <x-label>Data incial</x-label>
                        <x-date wire:model='startDate'
                                helpers
                                format="DD/MM/YYYY" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-label>Data final</x-label>
                        <x-date wire:model='endDate'
                                helpers
                                format="DD/MM/YYYY" />
                    </div>
                    <div class="sm:col-span-1">
                        <x-button text="Gerar"
                                  class="sm:mt-5 w-full"
                                  type="submit" />
                    </div>
                    <div class="sm:col-span-1">
                        <x-button text="Limpar"
                                  class="sm:mt-5 w-full"
                                  wire:click='clear' />
                    </div>
                </div>
                @if ($isSearched)
                    @if ($services->isEmpty()) <!-- Verifica se não há serviços -->
                        <x-alert close
                                 color='secondary'>
                            Nenhum resultado encontrado
                        </x-alert>
                    @else
                        <div class="px-4 py-6 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-0">
                            <div class="overflow-hidden dark:ring-dark-600 rounded-lg shadow ring-1 ring-gray-300">
                                <div class="relative soft-scrollbar overflow-auto">
                                    <table class="w-full divide-y divide-gray-300">
                                        <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="border py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                    Serviço
                                                </th>
                                                <th scope="col"
                                                    class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                                    Profissional
                                                </th>
                                                <th scope="col"
                                                    class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                                    Data
                                                </th>
                                                <th scope="col"
                                                    class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                                    Status
                                                </th>
                                                <th scope="col"
                                                    class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                                    Valor
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($services as $service)
                                                <tr>
                                                    <td class="relative border py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                        <div class="text-sm text-gray-500">
                                                            {{ $service->name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                        {{ $service->user->name }}
                                                    </td>
                                                    <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                        {{ \Carbon\Carbon::parse($service->service_date)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                        @if ($service->is_paid)
                                                            <span
                                                                  class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                                Pago
                                                            </span>
                                                        @else
                                                            <span
                                                                  class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                                                Em aberto
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                        {{ 'R$ ' . number_format($service->price, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="bg-gray-100">
                                                <td colspan="4"
                                                    class="border px-3 py-3.5 text-sm font-semibold text-gray-900">
                                                    Valor Total:
                                                </td>
                                                <td
                                                    class="border px-3 py-3.5 text-sm text-gray-500 lg:table-cell font-semibold">
                                                    R$ {{ number_format($totalValue, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </form>
    </div>
</div>
