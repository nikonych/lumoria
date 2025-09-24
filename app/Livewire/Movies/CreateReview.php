<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use App\Models\Review;
use App\Services\ActivityLogger;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateReview extends Component
{
    public Movie $movie;
    public ?Review $existingReview = null;

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

        // Check if user already has a review for this movie
        $this->existingReview = Review::where('user_id', Auth::id())
            ->where('movie_id', $this->movie->id)
            ->first();

        // If existing review found, populate the form with its data
        if ($this->existingReview) {
            $this->rating = $this->existingReview->rating;
            $this->title = $this->existingReview->title ?? '';
            $this->description = $this->existingReview->description ?? '';
        }
    }

    public function updateRating($rating)
    {
        $this->rating = $rating;
        $this->validateOnly('rating');
    }

    public function submit()
    {
        $this->validate();

        try {
            if ($this->existingReview) {
                // Update existing review
                $this->existingReview->update([
                    'rating' => $this->rating,
                    'title' => $this->title ?: null,
                    'description' => $this->description ?: null,
                ]);

                ActivityLogger::logMovieRated(auth()->user(), $this->existingReview->fresh());

                session()->flash('success', 'Ihre Bewertung wurde erfolgreich aktualisiert!');
            } else {
                // Create new review
                $review = Review::create([
                    'user_id' => Auth::id(),
                    'movie_id' => $this->movie->id,
                    'rating' => $this->rating,
                    'title' => $this->title ?: null,
                    'description' => $this->description ?: null,
                ]);

                $review->load('movie');

                ActivityLogger::logMovieRated(auth()->user(), $review);

                session()->flash('success', 'Ihre Bewertung wurde erfolgreich gespeichert!');
            }

            $this->updateMovieRating();

        } catch (\Exception $e) {
            $this->addError('general', 'Fehler beim Speichern der Bewertung: ' . $e->getMessage());
        }
    }

    public function deleteReview()
    {
        if (!$this->existingReview) {
            $this->addError('general', 'Keine Bewertung zum Löschen gefunden.');
            return;
        }

        try {
            $this->existingReview->delete();

            $this->updateMovieRating();

            // Reset form
            $this->existingReview = null;
            $this->rating = 0;
            $this->title = '';
            $this->description = '';

            session()->flash('success', 'Ihre Bewertung wurde erfolgreich gelöscht!');

        } catch (\Exception $e) {
            $this->addError('general', 'Fehler beim Löschen der Bewertung: ' . $e->getMessage());
        }
    }

    private function updateMovieRating(): void
    {
        $averageRating = Review::where('movie_id', $this->movie->id)
            ->avg('rating');

        $this->movie->update([
            'rating' => $averageRating ? round($averageRating, 2) : null,
        ]);
    }

    public function render()
    {
        return view('livewire.movies.create-review');
    }
}
