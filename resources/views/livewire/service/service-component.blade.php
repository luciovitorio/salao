<div>
    @if (session()->has('message'))
        <div class="mb-4">
            <x-alert close>
                {{ session('message') }}
            </x-alert>
        </div>
    @endif

    <x-Card title="Lista de serviços"
            buttonText="Cadastrar Serviço"
            link="services-create"
            secondBtn="true"
            secondBtnText="Entrada"
            secondBtnColor="secondary"
            linkSecondBtn="services-entry" />
    <x-table :$headers
             :$rows
             striped
             loading
             filter
             :quantity="[5, 10, 15, 20]"
             :$sort
             paginate
             id="service">

        @interact('column_description', $row)
            <div class="truncate w-32">
                {{ $row->description }}
            </div>
        @endinteract

        @interact('column_price', $row)
            R$ {{ number_format($row->price, 2, ',', '.') }}
        @endinteract

        @interact('column_action', $row)
            <div class="flex gap-5 justify-center">
                <x-button.circle color="primary"
                                 icon="eye"
                                 outline
                                 href="{{ route('services.show', $row->id) }}"
                                 wire:navigate
                                 x-tooltip="Visualizar serviço">
                </x-button.circle>
                <x-button.circle color="secondary"
                                 icon="pencil-square"
                                 outline
                                 href="{{ route('services.edit', $row->id) }}"
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
