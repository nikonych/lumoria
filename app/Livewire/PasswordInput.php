<?php

namespace App\Livewire;

use Livewire\Component;

class PasswordInput extends Component
{
    public string $name;
    public string $label;
    public string $placeholder = '*******';

    public string $value = '';
    public bool $showPassword = false;

    public function mount(string $name, string $label, string $placeholder = '*******'): void
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
    }

    public function updatedValue($value): void
    {
        $this->dispatch('input-value-updated', name: $this->name, value: $value);
    }

    public function toggleShowPassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.auth.password-input');
    }
}
