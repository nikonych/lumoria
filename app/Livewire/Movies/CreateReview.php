<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateReview extends Component
{
    public Movie $movie;

    public int $rating = 0;
    public string $title = '';
    public string $description = '';

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:2000',
    ];

    protected $messages = [
        'rating.required' => 'Bitte geben Sie eine Bewertung ab.',
        'rating.min' => 'Die Bewertung muss mindestens 1 Stern betragen.',
        'rating.max' => 'Die Bewertung darf maximal 5 Sterne betragen.',
        'title.max' => 'Der Titel darf maximal 255 Zeichen lang sein.',
        'description.max' => 'Die Bewertung darf maximal 2000 Zeichen lang sein.',
    ];

    public function mount(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function updateRating($rating)
    {
        $this->rating = $rating;
        $this->validateOnly('rating');
    }

    public function submit()
    {
        $this->validate();

        $existingReview = Review::where('user_id', Auth::id())
            ->where('movie_id', $this->movie->id)
            ->first();

        if ($existingReview) {
            $this->addError('general', 'Sie haben bereits eine Bewertung für diesen Film abgegeben.');
            return;
        }

        try {
            Review::create([
                'user_id' => Auth::id(),
                'movie_id' => $this->movie->id,
                'rating' => $this->rating,
                'title' => $this->title ?: null,
                'description' => $this->description ?: null,
            ]);

            $this->updateMovieRating();

            session()->flash('success', 'Ihre Bewertung wurde erfolgreich gespeichert!');


        } catch (\Exception $e) {
            $this->addError('general', 'Fehler beim Speichern der Bewertung: ' . $e->getMessage());
        }
    }

    private function updateMovieRating(): void
    {
        $averageRating = Review::where('movie_id', $this->movie->id)
            ->avg('rating');

        $this->movie->update([
            'rating' => round($averageRating, 2),
        ]);
    }

    public function render()
    {
        return view('livewire.movies.create-review');
    }
}
