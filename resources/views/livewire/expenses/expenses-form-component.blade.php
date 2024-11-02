<div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
    <form wire:submit.prevent={{ $type === 'edição' ? 'edit' : 'create' }}>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Formulário de {{ $this->type }} de despesas
                </h2>
            </div>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <x-input label="Despesa *"
                             wire:model='name' />
                </div>
                <div class="sm:col-span-2">
                    <x-input label="Valor *"
                             wire:model='value'
                             x-mask:dynamic="monetary"
                             placeholder="R$ 0,00" />
                </div>
                <div class="sm:col-span-1">
                    <x-label>Data de vencimento *</x-label>
                    <x-date wire:model='due_date'
                            helpers
                            format="DD/MM/YYYY" />
                </div>
                <div class="sm:col-span-2">
                    <x-textarea label="Descrição"
                                wire:model='description' />
                </div>
                <div class="sm:col-span-2">
                    <x-checkbox label="Foi pago"
                                wire:model.live='is_paid' />
                </div>
                <div class="sm:col-span-2">
                    <x-checkbox label="Me lembrar"
                                wire:model.live='remember_me' />
                </div>

            </div>
            <div class="mt-6 flex items-center gap-x-6">
                <button type="button"
                        href="{{ route('expenses') }}"
                        wire:navigate
                        class="text-sm font-semibold leading-6 text-gray-900">
                    Cancelar
                </button>
                <button type="submit"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ $type === 'edição' ? 'Atualizar' : 'Salvar' }}
                </button>
            </div>
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
