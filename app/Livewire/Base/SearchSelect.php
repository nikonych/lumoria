<?php

namespace App\Livewire\Base;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SearchSelect extends Component
{
    public array $options = [];

    #[Modelable]
    public ?string $value = null;

    public string $label = '';
    public string $class = '';
    public ?string $icon = null;
    public string $searchTerm = '';

    public function mount(array $options = [], ?string $value = null, string $label = '', ?string $icon = null, string $class = '')
    {
        $this->options = $options;
        $this->value = $value;
        $this->label = $label;
        $this->icon = $icon;
        $this->class = $class;
        $this->searchTerm = $this->selectedText();
    }

    public function selectOption(string $value)
    {
        $this->value = $value;
        $this->searchTerm = $this->selectedText();
    }

    public function updatedSearchTerm()
    {
        $exactMatch = collect($this->options)->first(function ($option) {
            return strtolower($option['text']) === strtolower($this->searchTerm);
        });

        if (!$exactMatch) {
            $this->value = null;
        }
    }

    #[Computed]
    public function selectedText(): string
    {
        if (is_null($this->value)) {
            return $this->label;
        }

        $selected = collect($this->options)->firstWhere('value', $this->value);

        return $selected['text'] ?? $this->label;
    }

    #[Computed]
    public function filteredOptions(): array
    {
        if (empty($this->searchTerm)) {
            return $this->options;
        }

        $selectedText = $this->selectedText();

        if ($this->searchTerm === $selectedText && $this->value !== null) {
            return $this->options;
        }

        return collect($this->options)
            ->filter(fn($option) => str_contains(strtolower($option['text']), strtolower($this->searchTerm)))
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire.base.search-select');
    }
}
