<div>
    @if (session()->has('message'))
        <div class="mb-4">
            <x-alert close>
                {{ session('message') }}
            </x-alert>
        </div>
    @endif

    <x-Card title="Lista de vendas"
            buttonText="Criar Venda"
            link="sales-create" />
    <x-table :$headers
             :$rows
             striped
             loading
             filter
             :quantity="[5, 10, 15, 20]"
             :$sort
             paginate
             id="sale">

        @interact('column_is_paid', $row)
            @if ($row->is_paid)
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
        @endinteract

        @interact('column_total_price', $row)
            R$ {{ number_format($row->total_price, 2, ',', '.') }}
        @endinteract

        @interact('column_sale_date', $row)
            {{ \Carbon\Carbon::parse($row->sale_date)->format('d/m/Y') }}
        @endinteract

        @interact('column_action', $row)
            <div class="flex gap-5 justify-center">
                <x-button.circle color="primary"
                                 icon="eye"
                                 outline
                                 href="{{ route('sales.show', $row->id) }}"
                                 wire:navigate
                                 x-tooltip="Visualizar venda">
                </x-button.circle>
                <x-button.circle color="secondary"
                                 icon="pencil-square"
                                 outline
                                 href="{{ route('sales.edit', $row->id) }}"
                                 wire:navigate
                                 x-tooltip="Editar" />
                <x-button.circle color="red"
                                 icon="trash"
                                 outline
                                 wire:click="delete('{{ $row->id }}')"
                                 x-tooltip="Excluir" />
            </div>
        @endinteract
    </x-table>
</div>
