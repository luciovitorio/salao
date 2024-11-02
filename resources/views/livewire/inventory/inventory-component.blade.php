<div>
    @if (session()->has('message'))
        <div class="mb-4">
            <x-alert close>
                {{ session('message') }}
            </x-alert>
        </div>
    @endif

    <x-Card title="Lista de entradas"
            buttonText="Entrada Produto"
            link="inventories/create" />
    <x-table :$headers
             :$rows
             striped
             loading
             filter
             :quantity="[5, 10, 15, 20]"
             :$sort
             paginate
             id="products">
        @interact('column_unit_price', $row)
            R$ {{ number_format($row->unit_price, 2, ',', '.') }}
        @endinteract
        @interact('column_total_cost', $row)
            R$ {{ number_format($row->total_cost, 2, ',', '.') }}
        @endinteract
        @interact('column_product_id', $row)
            {{ $row->product->name ?? 'Produto não encontrado' }}
        @endinteract
        @interact('column_entry_date', $row)
            {{ \Carbon\Carbon::parse($row->entry_date)->format('d/m/Y') }}
        @endinteract
        @interact('column_action', $row)
            <div class="flex gap-5 justify-center">
                <x-button.circle color="primary"
                                 icon="eye"
                                 outline
                                 href="{{ route('inventories.show', $row->id) }}"
                                 x-tooltip="Estoque"
                                 wire:navigate />
                <x-button.circle color="secondary"
                                 icon="pencil-square"
                                 outline
                                 href="{{ route('inventories.edit', $row->id) }}"
                                 x-tooltip="Editar"
                                 wire:navigate />
                <x-button.circle color="red"
                                 icon="trash"
                                 outline
                                 x-tooltip="Excluir"
                                 wire:click="delete('{{ $row->id }}')" />
            </div>
        @endinteract
    </x-table>
</div>
