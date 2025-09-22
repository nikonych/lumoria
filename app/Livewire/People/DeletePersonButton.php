<?php

namespace App\Livewire\People;

use App\Models\Movie;
use App\Models\Person;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class DeletePersonButton extends Component
{
    public Person $person;
    public bool $showConfirmModal = false;

    public function mount(Person $person)
    {
        $this->person = $person;
    }

    public function confirmDelete()
    {
        if (auth()->user()->id !== $this->person->created_by) {
            abort(403, 'Unauthorized');
        }

        $this->showConfirmModal = true;
    }

    public function delete()
    {
        try {
            if ($this->person->profile_image) {
                Storage::disk('public')->delete($this->person->profile_image);
            }

            foreach ($this->person->photos as $photo) {
                Storage::disk('public')->delete($photo->file_path);
            }

            $this->person->delete();

            return redirect()->route('people.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Fehler beim Löschen: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.people.delete-movie-button');
    }
}
