<?php

namespace App\Livewire\Traits\CreateMovie;

trait ManagesCrew
{
    public array $crew = [];

    public function initializeCrew(): void
    {
        if (empty($this->crew)) {
            $this->crew[] = ['person_id' => '', 'department_id' => '', 'position' => ''];
        }
    }

    public function addCrewMember(): void
    {
        $this->crew[] = ['person_id' => '', 'department_id' => '', 'position' => ''];
    }

    public function removeCrewMember(int $index): void
    {
        unset($this->crew[$index]);
        $this->crew = array_values($this->crew);
    }

    public function clearCrewMember(int $index): void
    {
        $this->crew[$index]['person_id'] = '';
        $this->crew[$index]['department_id'] = '';
        $this->crew[$index]['position'] = '';
    }
}
