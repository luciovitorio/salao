<div>
    @if (session()->has('message'))
        <div class="mb-4">
            <x-alert close>
                {{ session('message') }}
            </x-alert>
        </div>
    @endif

    <x-Card title="Lista de produtos"
            buttonText="Criar Produto"
            link="products-create" />
    <x-table :$headers
             :$rows
             striped
             loading
             filter
             :quantity="[5, 10, 15, 20]"
             :$sort
             paginate
             id="products">
        @interact('column_qtd_stock', $row)
            @if ($row->unit_type === 'ML')
                {{ number_format($row->qtd_stock, 1, ',', '.') }} ml
            @else
                {{ number_format($row->qtd_stock, 1, ',', '.') }} un
            @endif
        @endinteract
        @interact('column_cost_price', $row)
            R$ {{ number_format($row->cost_price, 2, ',', '.') }}
        @endinteract
        @interact('column_sale_price', $row)
            R$ {{ number_format($row->sale_price, 2, ',', '.') }}
        @endinteract
        @interact('column_action', $row)
            <div class="flex gap-5 justify-center">
                <x-button.circle color="secondary"
                                 icon="pencil-square"
                                 outline
                                 href="{{ route('products.edit', $row->id) }}"
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
