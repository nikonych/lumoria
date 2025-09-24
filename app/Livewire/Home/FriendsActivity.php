<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Friendship;

class FriendsActivity extends Component
{
    public function acceptFriendRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);

        if ($friendship->friend_id !== auth()->id()) {
            return;
        }

        $friendship->update(['status' => 'accepted']);
        session()->flash('message', 'Freundschaftsanfrage angenommen!');
    }

    public function declineFriendRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);

        if ($friendship->friend_id !== auth()->id()) {
            return;
        }

        $friendship->update(['status' => 'declined']);
        session()->flash('message', 'Freundschaftsanfrage abgelehnt.');
    }

    public function render()
    {

        $activities = auth()->user()->getFriendsActivities();

        $activities = $activities->filter(function($activity) {
            if ($activity->activity_type === 'friend_request_sent') {
                $displayData = $activity->getDisplayData();
                if ($displayData['target_user_id'] === auth()->id()) {
                    $friendship = \App\Models\Friendship::find($displayData['friendship_id']);
                    return $friendship && $friendship->status === 'pending';
                }
            }
            return true;
        });

        return view('livewire.home.friends-activity', compact('activities'));
    }
}
