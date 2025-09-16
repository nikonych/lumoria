<?php

namespace App\Livewire\Base;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Selection extends Component
{
    public array $options = [];

    #[Modelable]
    public ?string $value = null;

    public string $label = '';
    public string $class = '';
    public bool $selectFirst = false;

    public function mount(array $options = [], ?string $value = null, string $label = '', bool $selectFirst = false, string $class = '')
    {
        $this->options = $options;
        $this->value = $value;
        $this->class = $class;
        $this->label = $label;
        $this->selectFirst = $selectFirst;

        if ($this->selectFirst && is_null($this->value) && !empty($this->options)) {
            $this->value = $this->options[0]['value'];
        }
    }

    public function selectOption(string $value)
    {
        $this->value = $value;
    }

    #[Computed]
    public function selectedText(): string
    {
        $selected = collect($this->options)->firstWhere('value', $this->value);
        return $selected['text'] ?? $this->label;
    }

    public function render()
    {
        return view('livewire.base.selection');
    }
}

