<div>
    <x-button icon="arrow-left"
              position="left"
              class="mb-2"
              outline
              sm
              href="{{ route('sales') }}"
              wire:navigate>
        Voltar
    </x-button>
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
        <div class="px-4 sm:px-0">
            <h3 class="text-base font-semibold leading-7 text-gray-900">
                Informação da Venda
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
                Segue os detalhes da venda.
            </p>
        </div>
        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">
                        Situação
                    </dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        @if ($is_paid)
                            <span
                                  class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                Pago
                            </span>
                        @else
                            <span
                                  class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                Não pago
                            </span>
                        @endif
                    </dd>
                </div>
                @if ($is_paid)
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">
                            Forma de pagamento
                        </dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            {{ $payment_type }}
                        </dd>
                    </div>
                @endif

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">
                        Valor Total
                    </dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ 'R$ ' . number_format($total_price, 2, ',', '.') }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">
                        Data da venda
                    </dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ \Carbon\Carbon::parse($sale_date)->format('d/m/Y') }}
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
                    <h3 class="text-base font-semibold leading-7 text-gray-900">
                        Produtos
                    </h3>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-0">
                    <div class="overflow-hidden dark:ring-dark-600 rounded-lg shadow ring-1 ring-gray-300">
                        <div class="relative soft-scrollbar overflow-auto">
                            <table class="w-full divide-y divide-gray-300">
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
                                            Preço unitário
                                        </th>
                                        <th scope="col"
                                            class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                            Subtotal
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
                                                {{ $product['quantity'] }}
                                            </td>
                                            <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                {{ $product['unit_price'] }}
                                            </td>
                                            <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                {{ $product['subtotal'] }}
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
                                    <tr class="bg-gray-100">
                                        <td colspan="3"
                                            class="border px-3 py-3.5 text-sm font-semibold text-gray-900">
                                            Total:
                                        </td>
                                        <td
                                            class="border px-3 py-3.5 text-sm text-gray-500 lg:table-cell font-semibold">
                                            R$ {{ number_format($total_price, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </dl>
        </div>
    </div>
</div>
