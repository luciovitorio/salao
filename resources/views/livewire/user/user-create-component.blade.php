<div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
    <form wire:submit.prevent={{ $type === 'edição' ? 'edit' : 'create' }}>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Formulário de {{ $this->type }} de usuário
                </h2>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <x-input label="Nome *"
                                 wire:model='name' />
                    </div>


                    @if ($role === 'Administrador')
                        <div class="sm:col-span-3">
                            <x-input label="Nome de usuário"
                                     wire:model='username'
                                     hint="O valor desse campo deve ser único e sem espaços" />
                        </div>
                    @endif

                    <div class="sm:col-span-3">
                        <x-input label="Endereço de e-mail"
                                 wire:model='email'
                                 type='email' />
                    </div>

                    <div class="sm:col-span-3">
                        <x-label>Selecione um perfil *</x-label>
                        <x-select.styled wire:model.live='role'
                                         :options="['Administrador', 'Funcionário']" />
                    </div>

                    @if ($role === 'Administrador')
                        <div class="col-span-3">
                            <x-password label="Senha"
                                        wire:model='password' />
                        </div>
                    @endif

                    @if ($role === 'Administrador')
                        <div class="col-span-3">
                            <x-password label="Confirmar senha"
                                        wire:model='confirm_password' />
                        </div>
                    @endif

                    <div class="col-span-3">
                        <x-input label="Comissão %"
                                 type="number"
                                 min=0
                                 wire:model='commission' />
                    </div>


                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button"
                    href="{{ route('users') }}"
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
