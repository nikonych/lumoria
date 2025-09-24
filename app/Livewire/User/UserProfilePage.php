<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Friendship;
use Livewire\Component;
use Livewire\Attributes\Computed;

class UserProfilePage extends Component
{
    public User $user;
    public $activeTab = 'favoriten';

    public $viewingCollection = null;

    public function viewCollection($collectionId)
    {
        $this->viewingCollection = $this->user->collections()
            ->where('is_public', true)
            ->with('movies')
            ->findOrFail($collectionId);
    }

    public function backToCollections()
    {
        $this->viewingCollection = null;
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    #[Computed]
    public function userCollections()
    {
        return $this->user->collections()
            ->where('is_public', true) // Показываем только публичные коллекции
            ->withCount('movies')
            ->with(['movies' => function ($query) {
                $query->select('movies.id', 'movies.poster_image')->limit(1);
            }])
            ->get();
    }

    #[Computed]
    public function reviews()
    {
        return $this->user->ratings()
            ->with('movie')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    #[Computed]
    public function favoriteMovies()
    {
        return $this->user->favoriteMovies()->get();
    }

    #[Computed]
    public function friendship()
    {
        return Friendship::where(function($query) {
            $query->where('user_id', auth()->id())
                ->where('friend_id', $this->user->id);
        })->orWhere(function($query) {
            $query->where('user_id', $this->user->id)
                ->where('friend_id', auth()->id());
        })->first();
    }

    public function sendFriendRequest()
    {
        if (auth()->id() === $this->user->id) {
            return;
        }

        $existingRequest = $this->friendship;
        if ($existingRequest) {
            session()->flash('error', 'Freundschaftsanfrage bereits vorhanden.');
            return;
        }

        Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $this->user->id,
            'status' => 'pending'
        ]);

        // Обновляем computed property
        unset($this->friendship);
        session()->flash('message', 'Freundschaftsanfrage gesendet!');
    }

    public function acceptFriendRequest()
    {
        $friendship = $this->friendship;
        if (!$friendship || $friendship->friend_id !== auth()->id() || $friendship->status !== 'pending') {
            return;
        }

        $friendship->update(['status' => 'accepted']);
        unset($this->friendship);
        session()->flash('message', 'Freundschaftsanfrage angenommen!');
    }

    public function declineFriendRequest()
    {
        $friendship = $this->friendship;
        if (!$friendship || $friendship->friend_id !== auth()->id() || $friendship->status !== 'pending') {
            return;
        }

        $friendship->update(['status' => 'declined']);
        unset($this->friendship);
        session()->flash('message', 'Freundschaftsanfrage abgelehnt.');
    }

    public function render()
    {
        return view('livewire.user.user-profile-page');
    }
}
