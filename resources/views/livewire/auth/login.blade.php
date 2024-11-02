<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto"
             src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
             alt="Your Company">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
            Faça login com sua conta
        </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6"
              wire:submit.prevent="login">
            <div>
                <x-input wire:model="username"
                         label="Usuário"
                         icon="user"
                         position="right"
                         class="" />
            </div>
            <div>
                <x-password wire:model="password"
                            label="Senha" />
            </div>

            <div>
                <x-button icon="lock-closed"
                          class="w-full"
                          position="left"
                          type='submit'>
                    Entrar
                </x-button>
            </div>
        </form>
    </div>
</div>
