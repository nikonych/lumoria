<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Friendship;
use Livewire\Component;
use Livewire\Attributes\Computed;

class FriendActions extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    #[Computed]
    public function friendship()
    {
        if (auth()->id() === $this->user->id) {
            return null;
        }

        return Friendship::where(function($query) {
            $query->where('user_id', auth()->id())
                ->where('friend_id', $this->user->id);
        })->orWhere(function($query) {
            $query->where('user_id', $this->user->id)
                ->where('friend_id', auth()->id());
        })->first();
    }

    public function removeFriend()
    {
        $friendship = $this->friendship;

        if (!$friendship || $friendship->status !== 'accepted') {
            session()->flash('error', 'Freundschaft nicht gefunden.');
            return;
        }

        $friendship->delete();

        unset($this->friendship);

        session()->flash('message', 'Freund entfernt.');

        return redirect()->route('profile');
    }

    public function render()
    {
        return view('livewire.user.friend-actions');
    }
}
