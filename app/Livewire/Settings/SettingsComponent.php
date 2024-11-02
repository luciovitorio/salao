<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Attributes\Title;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Title('Configuração')]
class SettingsComponent extends Component
{
    use Interactions;

    public $home_percent;
    public $tithe;

    public function mount()
    {
        $settings = Setting::find(1);
        $this->home_percent = $settings->home_percent ?? 0;
        $this->tithe = $settings->tithe ?? 0;
    }

    public function render()
    {
        return view('livewire.settings.settings-component');
    }

    public function save()
    {
        $rules = [
            'home_percent' => 'required|numeric|min:0|max:100',
            'tithe' => 'required|numeric|min:0|max:100',
        ];

        $messages = [
            'home_percent.required' => 'Este campo é obrigatório',
            'home_percent.numeric' => 'Este campo deve ser numérico',
            'home_percent.min' => 'Este campo deve ser maior que 0',
            'home_percent.max' => 'Este campo deve ser no máximo 100',
            'tithe.required' => 'Este campo é obrigatório',
            'tithe.numeric' => 'Este campo deve ser numérico',
            'tithe.min' => 'Este campo deve ser maior que 0',
            'tithe.max' => 'Este campo deve ser no máximo 100',
        ];

        $this->validate($rules, $messages);

        $settings = Setting::find(1);

        if ($settings) {
            $settings->home_percent = $this->home_percent;
            $settings->tithe = $this->tithe;
            $settings->save();
            return $this->toast()->success('Configurações atualizadas com sucesso.')->send();
        }

        Setting::create([
            'home_percent' => $this->home_percent,
            'tithe' => $this->tithe,
        ]);

        return $this->toast()->success('Configurações atualizadas com sucesso.')->send();
    }
}
