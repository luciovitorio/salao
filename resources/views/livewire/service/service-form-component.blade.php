<div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
    <form wire:submit.prevent={{ $type === 'edição' ? 'edit' : 'create' }}>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Formulário de {{ $this->type }} de serviço
                </h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <x-input label="Nome do serviço *"
                                 wire:model='name' />
                    </div>

                    <div class="sm:col-span-3">
                        <x-textarea label="Descrição do serviço"
                                    wire:model='description' />
                    </div>

                    <div class="sm:col-span-2">
                        <x-input label="Preço *"
                                 wire:model='price'
                                 x-mask:dynamic="monetary"
                                 placeholder="R$ 0,00" />
                    </div>
                </div>
            </div>
        </div>
        <div class="border-b border-gray-900/10 pb-12 mt-2">
            <h2 class="text-base font-semibold leading-7 text-gray-900">
                Produtos utilizados
            </h2>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <x-label>Selecione o produto *</x-label>
                    <x-select.styled wire:model.live='product_id'
                                     :options="$productsOptionsSelect"
                                     select="label:label|value:value"
                                     searchable />
                </div>
                <div class="sm:col-span-2">
                    <x-input label="Quantidade *"
                             wire:model='used_quantity'
                             type="number"
                             min='0'
                             :step="$qtd_used_per_service"
                             hint="Se for líquido colocar em ML" />
                </div>
                <div class="sm:col-span-2 mt-5">
                    <x-button.circle icon="plus"
                                     href="#"
                                     color="primary"
                                     wire:click.prevent='handleAddProduct' />
                </div>

                <div class="sm:col-span-4">
                    @if (count($addedProducts) > 0)
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
                                        class=" border px-3 py-3.5 text-center text-sm font-semibold text-gray-900 lg:table-cell">
                                        Excluir
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
                                            {{ $product['quantity'] }} {{ $product['unit_type'] }}
                                        </td>
                                        <td class="px-3 border py-3.5 text-sm text-gray-500 lg:table-cell text-center">
                                            <x-button.circle icon="trash"
                                                             href="#"
                                                             color="red"
                                                             wire:click.prevent="removeProduct({{ $loop->index }})" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-4 bg-primary-100 rounded-md shadow-md">
                            <p class="text-gray-500 text-sm">Nenhum produto selecionado.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button"
                    href="{{ route('services') }}"
                    wire:navigate
                    class="text-sm font-semibold leading-6 text-gray-900">
                Cancelar
            </button>
            <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                {{ $type === 'edição' ? 'Atualizar' : 'Salvar' }}
            </button>
        </div>
    </form>
</div>

<script>
    function monetary(value, decimal = ',', thousand = '.', decimalPlaces = 2) {
        let number = value.replace(/[^\d]/g, ''); // Remove tudo exceto números
        number = parseFloat(number / Math.pow(10, decimalPlaces)).toFixed(
            decimalPlaces); // Converte para número correto

        let [integerPart, decimalPart] = number.split('.');
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousand); // Adiciona o separador de milhar

        return `R$ ${integerPart}${decimal}${decimalPart}`;
    }
</script>
