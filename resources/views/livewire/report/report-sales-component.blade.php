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
                    @if ($sales->isEmpty()) <!-- Verifica se não há serviços -->
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
                                                    Data
                                                </th>
                                                <th scope="col"
                                                    class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                                    Forma de pagamento
                                                </th>
                                                <th scope="col"
                                                    class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                                    Valor
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sales as $sale)
                                                <tr>
                                                    <td class="relative border py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                        <div class="text-sm text-gray-500">
                                                            {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                                                        </div>
                                                    </td>
                                                    <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                        {{ $sale->payment_type }}
                                                    </td>
                                                    <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                        {{ 'R$ ' . number_format($sale->total_price, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="bg-gray-100">
                                                <td colspan="2"
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
