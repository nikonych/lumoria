<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class DeleteMovieButton extends Component
{
    public Movie $movie;
    public bool $showConfirmModal = false;

    public function mount(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function confirmDelete()
    {
        if (auth()->user()->id !== $this->movie->created_by) {
            abort(403, 'Unauthorized');
        }

        $this->showConfirmModal = true;
    }

    public function delete()
    {
        try {
            if ($this->movie->poster_image) {
                Storage::disk('public')->delete($this->movie->poster_image);
            }

            foreach ($this->movie->photos as $photo) {
                Storage::disk('public')->delete($photo->file_path);
            }

            $this->movie->delete();

            return redirect()->route('movies.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Fehler beim Löschen: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.movies.delete-movie-button');
    }
}
