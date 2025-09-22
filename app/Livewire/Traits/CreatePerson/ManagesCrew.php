<?php

namespace App\Livewire\Traits\CreatePerson;

trait ManagesCrew
{

    public function initializeCrew(): void
    {
        if (empty($this->crew)) {
            $this->crew[] = [
                'id' => ++$this->crewCounter,
                'movie_id' => '',
                'department_id' => '',
                'position' => ''
            ];
        }
    }

    public function addCrewMember(): void
    {
        $this->crew[] = [
            'id' => ++$this->crewCounter,
            'movie_id' => '',
            'department_id' => '',
            'position' => ''
        ];
    }

    public function removeCrewMember(int $id): void
    {
        $this->crew = collect($this->crew)->reject(fn($member) => $member['id'] === $id)->values()->toArray();
        $this->form->crew = collect($this->crew)->reject(fn($member) => $member['id'] === $id)->values()->toArray();
    }

    public function clearCrewMember(int $id): void
    {
        $index = collect($this->crew)->search(fn($member) => $member['id'] === $id);
        if ($index !== false) {
            $this->crew[$index]['movie_id'] = '';
            $this->crew[$index]['department_id'] = '';
            $this->crew[$index]['position'] = '';
        }
    }
}
