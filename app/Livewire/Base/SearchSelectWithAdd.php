<?php

namespace App\Livewire\Base;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SearchSelectWithAdd extends Component
{
    public array $options = [];

    protected $listeners = ['updatePeopleOptions' => 'updateOptions'];

    public function updateOptions($options)
    {
        $this->options = $options;
    }

    #[Modelable]
    public ?string $value = null;

    public string $label = '';
    public string $class = '';
    public ?string $icon = null;
    public string $searchTerm = '';
    public string $newItemInput = '';

    public string $modelClass = '';
    public string $modelCreateField = 'name';

    public function mount(array $options = [],
                          ?string $value = null,
                          string $label = '',
                          ?string $icon = null,
                          string $class = '',
                          string $modelClass = '',
                          string $modelCreateField = 'name'
    )
    {
        $this->options = $options;
        $this->value = $value;
        $this->label = $label;
        $this->icon = $icon;
        $this->class = $class;
        $this->searchTerm = $this->selectedText();

        $this->modelClass = $modelClass;
        $this->modelCreateField = $modelCreateField;
    }

    public function selectOption(string $value)
    {
        $this->value = $value;
        $this->searchTerm = $this->selectedText();
    }

    public function addNewItem()
    {
        $newItemText = trim($this->newItemInput);

        if (empty($newItemText)) {
            return;
        }

        $exists = collect($this->options)->contains(function ($option) use ($newItemText) {
            return strtolower($option['text']) === strtolower($newItemText);
        });

        if ($exists) {
            return;
        }

        if (!empty($this->modelClass) && class_exists($this->modelClass)) {
            $newRecord = $this->modelClass::create([
                $this->modelCreateField => $newItemText,
            ]);

            $newValue = $newRecord->id;
            $newText = $newRecord->{$this->modelCreateField};

        } else {
            $newValue = strtolower(str_replace(' ', '_', $newItemText));
            $newText = $newItemText;
        }

        $this->options[] = [
            'value' => $newValue,
            'text' => $newText
        ];

        $this->selectOption($newValue);

        $this->newItemInput = '';

        $this->dispatch('optionsUpdated', modelClass: $this->modelClass);
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

        $selected = collect($this->options)->firstWhere('value', $this->value);

        return $selected['text'] ?? '';
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
        return view('livewire.base.search-select-with-add');
    }
}
