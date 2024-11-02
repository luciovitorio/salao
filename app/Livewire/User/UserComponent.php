<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

#[Title('Usuários')]
class UserComponent extends Component
{
    use Interactions;
    use WithPagination;
    public ?int $quantity  = 5;

    public ?string $search = null;

    public array $sort = [
        'column' => 'id',
        'direction' => 'desc',
    ];

    public function render()
    {
        $headers =  [
            ['index' => 'name', 'label' => 'Nome'],
            ['index' => 'username', 'label' => 'Nome de usuário'],
            ['index' => 'role', 'label' => 'Perfil'],
            ['index' => 'commission', 'label' => 'Comissão %'],
            ['index' => 'action'],
        ];

        $rows = User::where('name', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity);

        return view('livewire.user.user-component', [
            'headers' => $headers,
            'rows' => $rows
        ]);
    }

    public function delete($userId): void
    {
        $this->dialog()
            ->question('Cuidado, essa ação não poderá ser desfeita!', 'Você tem certeza que quer excluir esse registro?')
            ->confirm('Excluir', 'confirmed', $userId)
            ->cancel('Cancelar', 'cancelled', 'Cancelado com sucesso')
            ->send();
    }

    public function confirmed($userId): void
    {
        $user = User::findOrFail($userId);
        $user->delete();

        $this->dialog()->success('Usuário excluído com sucesso!')->send();
    }

    public function cancelled(string $message): void
    {
        $this->dialog()->error('Ação cancelada!')->send();
    }
}
