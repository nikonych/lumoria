<?php

namespace App\Livewire\Traits\CreatePerson;

trait ManagesCast
{

    public function initializeCast(): void
    {
        if (empty($this->cast)) {
            $this->cast[] = [
                'id' => $this->castCounter++,
                'movie_id' => '',
                'role_name' => ''
            ];
        }
    }

    public function addActor(): void
    {
        $this->cast[] = [
            'id' => $this->castCounter++,
            'movie_id' => '',
            'role_name' => ''
        ];
    }

    public function removeActor(int $id): void
    {
        $this->cast = collect($this->cast)->reject(fn($actor) => $actor['id'] === $id)->values()->toArray();
        $this->form->cast = collect($this->cast)->reject(fn($actor) => $actor['id'] === $id)->values()->toArray();
    }

    public function clearActor(int $id): void
    {
        $index = collect($this->cast)->search(fn($actor) => $actor['id'] === $id);
        if ($index !== false) {
            $this->cast[$index]['movie_id'] = '';
            $this->cast[$index]['role_name'] = '';
        }
    }
}
