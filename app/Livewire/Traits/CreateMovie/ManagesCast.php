<?php

namespace App\Livewire\Traits\CreateMovie;

trait ManagesCast
{
    public array $cast = [];

    public function initializeCast(): void
    {
        if (empty($this->cast)) {
            $this->cast[] = ['person_id' => '', 'role_name' => ''];
        }
    }

    public function addActor(): void
    {
        $this->cast[] = ['person_id' => '', 'role_name' => ''];
    }

    public function removeActor(int $index): void
    {
        unset($this->cast[$index]);
        $this->cast = array_values($this->cast);
    }

    public function clearActor(int $index): void
    {
        $this->cast[$index]['person_id'] = '';
        $this->cast[$index]['role_name'] = '';
    }
}
