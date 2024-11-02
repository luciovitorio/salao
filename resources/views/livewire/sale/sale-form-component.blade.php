<div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
    <form wire:submit.prevent={{ $type === 'edição' ? 'edit' : 'create' }}>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Formulário de {{ $this->type }} de venda
                </h2>
            </div>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <x-label>Selecione o produto *</x-label>
                    <x-select.styled wire:model='product_id'
                                     :options="$productsOptionsSelect"
                                     select="label:label|value:value"
                                     searchable />
                </div>
                <div class="sm:col-span-2">
                    <x-input label="Quantidade *"
                             wire:model='used_quantity'
                             type="number" />
                </div>
                <div class="sm:col-span-2 mt-5">
                    <x-button.circle icon="plus"
                                     href="#"
                                     color="primary"
                                     wire:click.prevent='handleAddProduct' />
                </div>

                <div class="sm:col-span-5">
                    @if (count($addedProducts) > 0)
                        <div class="overflow-hidden dark:ring-dark-600 rounded-lg shadow ring-1 ring-gray-300">
                            <div class="relative soft-scrollbar overflow-auto">
                                <table class="w-full divide-gray-300 overflow-hidden">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="border py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                Produto
                                            </th>
                                            <th scope="col"
                                                class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                                Qtd
                                            </th>
                                            <th scope="col"
                                                class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                                Preço unitário
                                            </th>
                                            <th scope="col"
                                                class=" border px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                                Preço total
                                            </th>
                                            <th scope="col"
                                                class=" border px-3 py-3.5 text-center text-sm font-semibold text-gray-900 lg:table-cell">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($addedProducts as $product)
                                            <tr>
                                                <td class="relative border py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $product['name'] }}
                                                    </div>
                                                </td>
                                                <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                    {{ $product['quantity'] }}
                                                </td>
                                                <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                    {{ number_format($product['sale_price'], 2, ',', '.') }}
                                                </td>
                                                <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell">
                                                    {{ number_format($product['quantity'] * $product['sale_price'], 2, ',', '.') }}
                                                </td>
                                                <td
                                                    class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell text-center">
                                                    <x-button.circle icon="trash"
                                                                     href="#"
                                                                     color="red"
                                                                     wire:click.prevent="removeProduct({{ $loop->index }})" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tr class="bg-gray-100">
                                        <td colspan="4"
                                            class="border px-3 py-3.5 text-sm font-semibold text-gray-900">
                                            Total:
                                        </td>
                                        <td
                                            class="border px-3 py-3.5 text-sm text-gray-500 lg:table-cell font-semibold">
                                            R$ {{ number_format($total_price, 2, ',', '.') }}
                                        </td>

                                    </tr>
                                </table>
                                <input type="hidden"
                                       wire:model="total_price">
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4 bg-primary-100 rounded-md shadow-md">
                            <p class="text-gray-500 text-sm">Nenhum produto selecionado.</p>
                        </div>

                    @endif

                </div>
                @if (count($addedProducts) > 0)
                    <div class="sm:col-span-2">
                        <x-select.styled :options="['Pix', 'Dinheiro', 'Cartão']"
                                         wire:model='payment_type'
                                         label="Forma de pagamento *"
                                         :options="['Pix', 'Dinheiro', 'Cartão']" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-label>Data da venda *</x-label>
                        <x-date wire:model='sale_date'
                                helpers
                                format="DD/MM/YYYY" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-textarea label="Observação"
                                    wire:model='description' />
                    </div>
                @endif
            </div>

            @if (count($addedProducts) > 0)
                <div class="mt-6 flex items-center gap-x-6">
                    <button type="button"
                            href="{{ route('sales') }}"
                            wire:navigate
                            class="text-sm font-semibold leading-6 text-gray-900">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ $type === 'edição' ? 'Atualizar' : 'Salvar' }}
                    </button>
                </div>
            @endif
        </div>
    </form>
</div>
