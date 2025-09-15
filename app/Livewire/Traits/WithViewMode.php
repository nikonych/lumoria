<?php
namespace App\Livewire\Traits;

trait WithViewMode
{
    public string $viewMode = 'list';

    public function setView(string $mode): void
    {
        if (in_array($mode, ['grid', 'list'])) {
            $this->viewMode = $mode;
        }
    }
}
