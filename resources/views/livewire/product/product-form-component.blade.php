<div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
    <form wire:submit.prevent={{ $type === 'edição' ? 'edit' : 'create' }}>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Formulário de {{ $this->type }} de produto
                </h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <x-input label="Nome do produto *"
                                 wire:model='name' />
                    </div>

                    <div class="sm:col-span-3">
                        <x-input label="Categoria"
                                 wire:model='category' />
                    </div>

                    <div class="sm:col-span-2">
                        <x-input label="Quantidade em estoque"
                                 wire:model='qtd_stock'
                                 type="number"
                                 min='0'
                                 hint="Se for liquido cadastrar em ML" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-input label="Quantidade mínima"
                                 wire:model='qtd_min'
                                 type="number"
                                 min='0'
                                 hint="Valor será monitorado para alerta" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-label>Unidade de medida *</x-label>
                        <x-select.styled wire:model.live='unit_type'
                                         :options="['ML', 'Unidade']"
                                         placeholder="Selecione..." />
                    </div>

                    @if ($unit_type === 'ML')
                        <div class="sm:col-span-2">
                            <x-input label="Qtd por unidade"
                                     wire:model='quantity'
                                     type="number"
                                     min='0'
                                     hint="1L = 1000ml e/ou 1 unidade" />
                        </div>
                    @endif


                    <div class="sm:col-span-2">
                        <x-input label="Preço de custo"
                                 wire:model='cost_price'
                                 x-mask:dynamic="monetary"
                                 placeholder="R$ 0,00" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-input label="Preço de venda"
                                 wire:model='sale_price'
                                 x-mask:dynamic="monetary"
                                 placeholder="R$ 0,00" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input label="Quantidade de serviço *"
                                 wire:model='qtd_service'
                                 type="number"
                                 min='0'
                                 hint="Quantidade estimada de serviços que esse produto faz." />
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button"
                    href="{{ route('products') }}"
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
