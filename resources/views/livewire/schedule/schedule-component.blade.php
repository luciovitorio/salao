<div>
    @if (session()->has('message'))
        <div class="mb-4">
            <x-alert close>
                {{ session('message') }}
            </x-alert>
        </div>
    @endif

    <x-Card title="Lista de agendamentos"
            buttonText="Criar Agendamento"
            link="schedules-create"
            secondBtn
            secondBtnText='Limpar todos registros'
            secondIcon='trash'
            secondBtnColor='red'
            secondBtnAction="deleteAll" />
    <x-table :$headers
             :$rows
             striped
             loading
             filter
             :quantity="[5, 10, 15, 20]"
             :$sort
             paginate
             id="schedule">

        @interact('column_user_id', $row)
            {{ $row->user->name ?? 'Usuário não encontrado' }}
        @endinteract

        @interact('column_price', $row)
            R$ {{ number_format($row->price, 2, ',', '.') }}
        @endinteract

        @interact('column_schedule_data', $row)
            {{ \Carbon\Carbon::parse($row->schedule_data)->format('d/m/Y') }}
        @endinteract

        @interact('column_schedule_time', $row)
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $row->schedule_time)->format('H:i') }}
        @endinteract


        @interact('column_action', $row)
            <div class="flex gap-5 justify-center">
                <x-button.circle color="primary"
                                 icon="eye"
                                 outline
                                 href="{{ route('schedules.show', $row->id) }}"
                                 x-tooltip="Visualizar agendamento">
                </x-button.circle>
                <x-button.circle color="secondary"
                                 icon="pencil-square"
                                 outline
                                 href="{{ route('schedules.edit', $row->id) }}"
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
