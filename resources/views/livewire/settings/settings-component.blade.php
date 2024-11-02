<div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
    <form wire:submit.prevent=save>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Formulário de configuração
                </h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-1">
                        <x-input label="Caixa do salão *"
                                 type='number'
                                 step='0.1'
                                 min='0'
                                 wire:model='home_percent'
                                 hint='Valor em porcentagem' />
                    </div>

                    <div class="sm:col-span-1">
                        <x-input label="Dízimo *"
                                 type='number'
                                 step='0.1'
                                 min='0'
                                 wire:model='tithe'
                                 hint='Valor em porcentagem' />
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
                Salvar
            </button>
        </div>
    </form>
</div>
