<div
     class="-mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16 bg-white">
    <h2 class="text-base font-semibold leading-6 text-gray-900">
        Selecione o relatório
    </h2>

    <div class="mt-2">
        <div class="w-full flex flex-col gap-2 flex-wrap sm:flex-row">
            <x-button lg
                      class="sm:w-1/5"
                      href="{{ route('reports.services') }}"
                      wire:navigate>
                Serviços
            </x-button>
            <x-button lg
                      class="sm:w-1/5"
                      href="{{ route('reports.sales') }}"
                      wire:navigate>
                Vendas
            </x-button>
            <x-button lg
                      class="sm:w-1/5"
                      href="{{ route('reports.commission') }}"
                      wire:navigate>
                Comissão
            </x-button>
            <x-button lg
                      class="sm:w-1/5">
                Saídas
            </x-button>
            <x-button lg
                      class="sm:w-1/5"
                      href="{{ route('reports.cash') }}"
                      wire:navigate>
                Lucro
            </x-button>
            <x-button lg
                      class="sm:w-1/5"
                      href="{{ route('reports.cash') }}"
                      wire:navigate>
                Caixa do salão
            </x-button>
        </div>
    </div>


</div>
