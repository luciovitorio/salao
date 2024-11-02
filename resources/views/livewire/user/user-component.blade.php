<div>
    @if (session()->has('message'))
        <div class="mb-4">
            <x-alert close>
                {{ session('message') }}
            </x-alert>
        </div>
    @endif

    <x-Card title="Lista de usuários"
            buttonText="Criar Usuário"
            link="users-create" />
    <x-table :$headers
             :$rows
             striped
             loading
             filter
             :quantity="[5, 10, 15, 20]"
             :$sort
             paginate
             id="users">
        @interact('column_role', $row)
            @if ($row->role === 'Administrador')
                <span
                      class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                    {{ $row->role }}
                </span>
            @else
                <span
                      class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                    {{ $row->role }}
                </span>
            @endif
        @endinteract
        @interact('column_commission', $row)
            {{ $row->commission }}%
        @endinteract
        @interact('column_action', $row)
            <div class="flex gap-5 justify-center">
                <x-button.circle color="secondary"
                                 icon="pencil-square"
                                 outline
                                 href="{{ route('users.edit', $row->id) }}"
                                 wire:navigate />
                <x-button.circle color="red"
                                 icon="trash"
                                 outline
                                 wire:click="delete('{{ $row->id }}')" />
            </div>
        @endinteract
    </x-table>
</div>
