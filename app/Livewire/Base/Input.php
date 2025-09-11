<?php

namespace App\Livewire\Base;

use Livewire\Component;

class Input extends Component
{
    public $value = '';
    public string $id = '';
    public string $name = '';
    public string $placeholder = 'Search...';
    public bool $hasIcon = false;
    public ?string $label = null;
    public ?string $iconSvg = null;
    public string $class = '';
    public string $type = 'text';

    public function mount(
        string $id = null,
        string $name = null,
        string $placeholder = 'Search...',
        bool $hasIcon = false,
        string $class = '',
        string $label = null,
        string $type = 'text',
        string $iconSvg = null
    ) {
        $this->id = $id ?? 'search-input-' . uniqid();
        $this->name = $name ?? $this->id;
        $this->placeholder = $placeholder;
        $this->hasIcon = $hasIcon;
        $this->class = $class;
        $this->label = $label;
        $this->type = $type;
        $this->iconSvg = $iconSvg;

        if ($iconSvg) {
            $this->iconSvg = $this->addClassesToSvg($iconSvg);
        }
    }

    private function addClassesToSvg(string $svg): string
    {
        $classes = 'fill-slate-400 group-focus-within:fill-indigo-500';

        // Check if the SVG already has a class attribute
        if (str_contains($svg, 'class="')) {
            // If it does, append our classes to the existing ones
            return str_replace('class="', 'class="' . $classes . ' ', $svg);
        } else {
            // If not, add the class attribute right after the <svg tag
            return str_replace('<svg', '<svg class="' . $classes . '"', $svg);
        }
    }

    public function render()
    {
        return view('livewire.base.input');
    }
}
