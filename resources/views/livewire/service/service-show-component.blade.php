<div>
    <x-button icon="arrow-left"
              position="left"
              class="mb-2"
              outline
              sm
              href="{{ route('services') }}"
              wire:navigate>
        Voltar
    </x-button>
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
        <div class="px-4 sm:px-0">
            <h3 class="text-base font-semibold leading-7 text-gray-900">
                Informação do Serviço
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
                Segue os detalhes do serviço.
            </p>
        </div>
        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">
                        Nome do serviço
                    </dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $name }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">
                        Observação
                    </dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $description }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">
                        Preço
                    </dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ 'R$ ' . number_format($price, 2, ',', '.') }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-gray-900">
                        Produtos utilizados
                    </h3>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="border py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Produto
                                </th>
                                <th scope="col"
                                    class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                    Quantidade
                                </th>
                                <th scope="col"
                                    class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                    Custo
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($addedProducts as $product)
                                <tr>
                                    <td class="relative border py-4 pl-4 pr-3 text-sm sm:pl-6">
                                        <div class="text-sm text-gray-500">
                                            {{ $product['name'] }}
                                        </div>
                                    </td>
                                    <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                        {{ number_format($product['quantity'], 1, ',', '.') }}
                                        {{ $product['unit_type'] }}
                                    </td>
                                    <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                        {{ 'R$ ' . number_format($product['cost_price'], 2, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2"
                                        class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                        Nenhum produto adicionado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </dl>
        </div>
    </div>
</div>
