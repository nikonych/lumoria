<?php

namespace App\Livewire\Profile;

use App\Models\Friendship;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProfilePage extends Component
{
    use WithPagination, WithFileUploads;

    public $activeTab = 'freunde';
    public int $perPage = 10;
    public $searchQuery = '';

    public $collectionName = '';
    public $isPublic = false;
    public $selectedMovies = [];
    public $isEditing = false;

    public $viewingCollection = null;
    public $isEditingCollection = false;

    public $showAddMoviesModal = false;
    public $modalSearchQuery = '';
    public $modalSelectedMovies = [];

    public $isEditingProfile = false;

    public bool $viewingWatchlist = false;
    public bool $viewingFavorites = false;
    public $watchlistMovies;
    public $favoriteMovies;

    public $showAddFriendsModal = false;

    public $friendSearchQuery = '';

    public $showAddFriendsPage = false;



    public $profileForm = [
        'name' => '',
        'email' => '',
        'biography' => '',
        'selectedGenres' => [],
        'notifications' => [
            'email_new_movies' => false,
            'email_new_recommendations' => false,
            'email_friends_request' => false,
        ]
    ];

    public $profilePhoto;
    public $showPasswordModal = false;
    public $passwordForm = [
        'password' => '',
        'password_confirmation' => '',
    ];

    #[Computed]
    public function movies(): LengthAwarePaginator
    {
        $query = Movie::query();

        if (!empty($this->searchQuery)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $this->searchQuery . '%');
            });
        }

        return $query->paginate($this->perPage);
    }

    #[Computed]
    public function userCollections()
    {
        return auth()->user()->collections()->withCount('movies')->with(['movies' => function ($query) {
            $query->select('movies.id', 'movies.poster_image')->limit(1);
        }])->get();
    }

    #[Computed]
    public function genres()
    {
        return Genre::orderBy('name')->get();
    }

    #[Computed]
    public function reviews()
    {
        return Review::query()->
        where('user_id', auth()->user()->id)->
        orderBy('created_at')->paginate(10);
    }

    #[Computed]
    public function modalMovies(): LengthAwarePaginator
    {
        $query = Movie::query();

        if (!empty($this->modalSearchQuery)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->modalSearchQuery . '%')
                    ->orWhere('description', 'like', '%' . $this->modalSearchQuery . '%')
                    ->orWhere('director', 'like', '%' . $this->modalSearchQuery . '%');
            });
        }

        return $query->paginate(12, ['*'], 'modalPage');
    }


    #[Computed]
    public function friendRequests()
    {
        return Friendship::where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->with('user')
            ->get();
    }

    #[Computed]
    public function sentRequests()
    {
        return Friendship::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with('friend')
            ->get();
    }

    #[Computed]
    public function friends()
    {
        return Friendship::where(function($query) {
            $query->where('user_id', auth()->id())
                ->orWhere('friend_id', auth()->id());
        })
            ->where('status', 'accepted')
            ->with(['user', 'friend'])
            ->get()
            ->map(function($friendship) {
                return $friendship->user_id === auth()->id()
                    ? $friendship->friend
                    : $friendship->user;
            });
    }

    #[Computed]
    public function searchedUsers()
    {
        if (strlen($this->friendSearchQuery) < 2) {
            return User::query()
                ->where('id', '!=', auth()->id())
                ->inRandomOrder()
                ->paginate(6);
        }

        $currentUserId = auth()->id();

        return User::where('name', 'like', '%' . $this->friendSearchQuery . '%')
            ->where('id', '!=', $currentUserId)
            ->paginate(6);
    }

    private function getFriendIds()
    {
        return Friendship::where(function($query) {
            $query->where('user_id', auth()->id())
                ->orWhere('friend_id', auth()->id());
        })
            ->pluck('user_id')
            ->merge(
                Friendship::where(function($query) {
                    $query->where('user_id', auth()->id())
                        ->orWhere('friend_id', auth()->id());
                })->pluck('friend_id')
            )
            ->unique()
            ->filter(function($id) {
                return $id !== auth()->id();
            });
    }

    public function sendFriendRequest($userId)
    {
        $existingRequest = Friendship::where(function($query) use ($userId) {
            $query->where('user_id', auth()->id())
                ->where('friend_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('user_id', $userId)
                ->where('friend_id', auth()->id());
        })->first();

        if ($existingRequest) {
            session()->flash('error', 'Freundschaftsanfrage bereits vorhanden.');
            return;
        }

        $friendship = Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $userId,
            'status' => 'pending'
        ]);

        ActivityLogger::logFriendRequestSent(
            auth()->user(),
            User::find($userId),
            $friendship
        );

        session()->flash('message', 'Freundschaftsanfrage gesendet!');
    }


    public function acceptFriendRequest($requestId)
    {
        $request = Friendship::findOrFail($requestId);

        if ($request->friend_id !== auth()->id()) {
            session()->flash('error', 'Keine Berechtigung für diese Aktion.');
            return;
        }

        $request->update(['status' => 'accepted']);

        unset($this->friendRequests, $this->friends);
        session()->flash('message', 'Freundschaftsanfrage angenommen!');
    }


    public function declineFriendRequest($requestId)
    {
        $request = Friendship::findOrFail($requestId);

        if ($request->friend_id !== auth()->id()) {
            session()->flash('error', 'Keine Berechtigung für diese Aktion.');
            return;
        }

        $request->update(['status' => 'declined']);

        unset($this->friendRequests);
        session()->flash('message', 'Freundschaftsanfrage abgelehnt.');
    }


    public function cancelFriendRequest($requestId)
    {
        $request = Friendship::findOrFail($requestId);

        if ($request->user_id !== auth()->id()) {
            session()->flash('error', 'Keine Berechtigung für diese Aktion.');
            return;
        }

        $request->delete();

        unset($this->sentRequests);
        session()->flash('message', 'Freundschaftsanfrage zurückgezogen.');
    }


    public function removeFriend($friendshipId)
    {
        $friendship = Friendship::where('id', $friendshipId)
            ->where(function($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('friend_id', auth()->id());
            })
            ->first();

        if (!$friendship) {
            session()->flash('error', 'Freundschaft nicht gefunden.');
            return;
        }

        $friendship->delete();

        unset($this->friends);
        session()->flash('message', 'Freund entfernt.');
    }

    public function updatedFriendSearchQuery()
    {
        $this->searchUsers();
    }

    public function clearFriendSearch()
    {
        $this->friendSearchQuery = '';
        $this->searchedUsers = User::query()->inRandomOrder()->paginate(6);
    }

    public function acceptFriendRequestByUserId($userId)
    {
        $request = Friendship::where('user_id', $userId)
            ->where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$request) {
            session()->flash('error', 'Anfrage nicht gefunden.');
            return;
        }

        $request->update(['status' => 'accepted']);

        unset($this->friendRequests, $this->friends);
        $this->searchUsers(); // Обновляем поиск
        session()->flash('message', 'Freundschaftsanfrage angenommen!');
    }

    // Продолжение метода declineFriendRequestByUserId
    public function declineFriendRequestByUserId($userId)
    {
        $request = Friendship::where('user_id', $userId)
            ->where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$request) {
            session()->flash('error', 'Anfrage nicht gefunden.');
            return;
        }

        $request->update(['status' => 'declined']);

        unset($this->friendRequests);
        $this->searchUsers(); // Обновляем поиск
        session()->flash('message', 'Freundschaftsanfrage abgelehnt.');
    }

// Обновить метод для проверки статуса заявки
    private function getFriendshipStatus($userId)
    {
        $sentRequest = Friendship::where('user_id', auth()->id())
            ->where('friend_id', $userId)
            ->first();

        $receivedRequest = Friendship::where('user_id', $userId)
            ->where('friend_id', auth()->id())
            ->first();

        if ($sentRequest) {
            return [
                'type' => 'sent',
                'status' => $sentRequest->status,
                'id' => $sentRequest->id
            ];
        }

        if ($receivedRequest) {
            return [
                'type' => 'received',
                'status' => $receivedRequest->status,
                'id' => $receivedRequest->id
            ];
        }

        return null;
    }

// Обновить метод поиска пользователей
    public function searchUsers()
    {
        if (strlen($this->friendSearchQuery) < 2) {
            $this->searchedUsers = User::query()->inRandomOrder()->paginate(6);
            return;
        }

        $currentUserId = auth()->id();

        $this->searchedUsers = User::where('name', 'like', '%' . $this->friendSearchQuery . '%')
            ->where('id', '!=', $currentUserId)
            ->paginate(6);
    }



    public function updatedProfilePhoto()
    {
        $this->validate([
            'profilePhoto' => 'image|max:2048|mimes:jpeg,png,jpg', // 2MB максимум
        ], [
            'profilePhoto.image' => 'Datei muss ein Bild sein.',
            'profilePhoto.max' => 'Bilddatei darf maximal 2MB groß sein.',
            'profilePhoto.mimes' => 'Nur JPG, JPEG und PNG Formate sind erlaubt.',
        ]);
    }

    public function uploadProfilePhoto()
    {
        if (!$this->profilePhoto) {
            session()->flash('error', 'Bitte wählen Sie eine Datei aus.');
            return;
        }

        try {
            $user = auth()->user();

            // Удаляем старое фото если есть
            if ($user->profile_image && Storage::exists($user->profile_image)) {
                Storage::delete($user->profile_image);
            }

            // Сохраняем новое фото
            $path = $this->profilePhoto->store('profile-photos', 'public');

            $user->update([
                'profile_image' => $path
            ]);

            // Очищаем временный файл
            $this->profilePhoto = null;

            session()->flash('message', 'Profilbild erfolgreich hochgeladen!');

        } catch (\Exception $e) {
            session()->flash('error', 'Fehler beim Hochladen des Bildes. Bitte versuchen Sie es erneut.');
        }
    }

    public function removeProfilePhoto()
    {
        try {
            $user = auth()->user();

            if ($user->profile_image && Storage::exists($user->profile_image)) {
                Storage::delete($user->profile_image);
            }

            $user->update([
                'profile_image' => null
            ]);

            session()->flash('message', 'Profilbild erfolgreich entfernt!');

        } catch (\Exception $e) {
            session()->flash('error', 'Fehler beim Entfernen des Bildes.');
        }
    }

    // Методы для работы с паролем
    public function openPasswordModal()
    {
        $this->showPasswordModal = true;
        $this->passwordForm = [
            'password' => '',
            'password_confirmation' => '',
        ];
    }

    public function closePasswordModal()
    {
        $this->showPasswordModal = false;
        $this->passwordForm = [
            'password' => '',
            'password_confirmation' => '',
        ];
        $this->resetErrorBag(['passwordForm.password', 'passwordForm.password_confirmation']);
    }

    public function updatePassword()
    {
        $this->validate([
            'passwordForm.password' => 'required|string|min:8|confirmed',
            'passwordForm.password_confirmation' => 'required',
        ], [
            'passwordForm.password.required' => 'Das Passwort ist erforderlich.',
            'passwordForm.password.min' => 'Das Passwort muss mindestens 8 Zeichen lang sein.',
            'passwordForm.password.confirmed' => 'Die Passwort-Bestätigung stimmt nicht überein.',
            'passwordForm.password_confirmation.required' => 'Die Passwort-Bestätigung ist erforderlich.',
        ]);

        try {
            $user = auth()->user();
            $user->update([
                'password' => Hash::make($this->passwordForm['password'])
            ]);

            $this->closePasswordModal();
            session()->flash('message', 'Passwort erfolgreich geändert!');

        } catch (\Exception $e) {
            session()->flash('error', 'Fehler beim Ändern des Passworts. Bitte versuchen Sie es erneut.');
        }
    }

    public function setActiveTab($tab): void
    {
        $this->activeTab = $tab;
    }

    public function updatedSearchQuery(): void
    {
        $this->resetPage();
    }

    public function toggleEdit(): void
    {
        $this->isEditing = !$this->isEditing;
        if (!$this->isEditing) {
            $this->resetForm();
        }
        $this->viewingWatchlist = false;
        $this->viewingFavorites = false;
    }

    public function cancelEdit(): void
    {
        $this->isEditing = false;
        $this->viewingWatchlist = false;
        $this->viewingFavorites = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->collectionName = '';
        $this->isPublic = false;
        $this->selectedMovies = [];
    }

    public function editProfile()
    {
        $this->isEditingProfile = true;
        $user = auth()->user();
        $settings = $user->settings;
        $this->profileForm = [
            'name' => $user->name ?? '',
            'email' => $user->email ?? '',
            'biography' => $user->biography ?? '',
            'selectedGenres' => $user->favoriteGenres->pluck('id')->toArray() ?? [],
            'notifications' => [
                'email_new_movies' => $settings->email_new_movies ?? false,
                'email_new_recommendations' => $settings->email_new_recommendations ?? false,
                'email_friends_request' => $settings->email_friends_request ?? false,
            ]
        ];
    }

    public function updateProfile()
    {
        $this->validate([
            'profileForm.name' => 'required|string|max:255',
            'profileForm.email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'profileForm.biography' => 'nullable|string|max:300',
            'profileForm.selectedGenres' => 'array',
            'profileForm.notifications.email_new_movies' => 'boolean',
            'profileForm.notifications.email_new_recommendations' => 'boolean',
            'profileForm.notifications.email_friends_request' => 'boolean',
        ]);

        $user = auth()->user();

        // Обновляем основные данные пользователя
        $user->update([
            'name' => $this->profileForm['name'],
            'email' => $this->profileForm['email'],
            'biography' => $this->profileForm['biography'],
        ]);

        // Обновляем настройки уведомлений
        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'email_new_movies' => $this->profileForm['notifications']['email_new_movies'],
                'email_new_recommendations' => $this->profileForm['notifications']['email_new_recommendations'],
                'email_friends_request' => $this->profileForm['notifications']['email_friends_request'],
            ]
        );

        // Обновляем любимые жанры
        $user->favoriteGenres()->sync($this->profileForm['selectedGenres']);

        $this->isEditingProfile = false;
        session()->flash('message', 'Profil erfolgreich aktualisiert!');
    }

    public function cancelEditProfile()
    {
        $this->isEditingProfile = false;
        $this->profileForm = [
            'name' => '',
            'email' => '',
            'biography' => '',
            'selectedGenres' => [],
            'notifications' => [
                'email_new_movies' => false,
                'email_new_recommendations' => false,
                'email_friends_request' => false,
            ]
        ];
    }

    public function toggleMovieSelection($movieId)
    {
        if (in_array($movieId, $this->selectedMovies)) {
            $this->selectedMovies = array_diff($this->selectedMovies, [$movieId]);
        } else {
            $this->selectedMovies[] = $movieId;
        }
    }

    public function viewCollection($collectionId)
    {
        $this->viewingCollection = auth()->user()->collections()->with('movies')->findOrFail($collectionId);
        $this->viewingWatchlist = false;
        $this->viewingFavorites = false;
        $this->isEditingCollection = false;
        $this->isEditing = false;
        $this->watchlistMovies = null;
        $this->favoriteMovies = null;
    }

    public function editCollection()
    {
        $this->isEditingCollection = true;
        $this->collectionName = $this->viewingCollection->name;
        $this->isPublic = $this->viewingCollection->is_public;
    }

    public function updateCollection()
    {
        $this->validate([
            'collectionName' => 'required|string|max:255',
        ]);

        $this->viewingCollection->update([
            'name' => $this->collectionName,
            'is_public' => $this->isPublic,
        ]);

        $this->isEditingCollection = false;
        $this->viewingCollection->refresh();
        unset($this->userCollections);

        session()->flash('message', 'Sammlung erfolgreich aktualisiert!');
    }

    public function deleteCollection()
    {
        $this->viewingCollection->delete();
        $this->viewingCollection = null;
        unset($this->userCollections);

        session()->flash('message', 'Sammlung erfolgreich gelöscht!');
    }

    public function backToCollections()
    {
        $this->viewingWatchlist = false;
        $this->viewingFavorites = false;
        $this->viewingCollection = null;
        $this->isEditingCollection = false;
        $this->isEditing = false;
        $this->resetForm();

        $this->watchlistMovies = null;
        $this->favoriteMovies = null;
    }

    public function openAddMoviesModal()
    {
        $this->showAddMoviesModal = true;
        $this->modalSearchQuery = '';
        $this->modalSelectedMovies = [];
    }

    public function closeAddMoviesModal()
    {
        $this->showAddMoviesModal = false;
        $this->modalSearchQuery = '';
        $this->modalSelectedMovies = [];
    }

    public function toggleModalMovieSelection($movieId)
    {
        if (in_array($movieId, $this->modalSelectedMovies)) {
            $this->modalSelectedMovies = array_diff($this->modalSelectedMovies, [$movieId]);
        } else {
            $this->modalSelectedMovies[] = $movieId;
        }
    }

    public function addMoviesToCollection()
    {
        if (!empty($this->modalSelectedMovies)) {
            $this->viewingCollection->movies()->syncWithoutDetaching($this->modalSelectedMovies);
            $this->viewingCollection->refresh();
            $this->viewingCollection->load('movies');
            unset($this->userCollections);
        }

        $this->closeAddMoviesModal();
        session()->flash('message', 'Filme erfolgreich hinzugefügt!');
    }

    public function updatedModalSearchQuery()
    {
        $this->resetPage('modalPage');
    }

    public function removeMovieFromCollection($movieId)
    {
        $this->viewingCollection->movies()->detach($movieId);
        $this->viewingCollection->refresh();
        $this->viewingCollection->load('movies');
        unset($this->userCollections);

        session()->flash('message', 'Film erfolgreich entfernt!');
    }

    public function saveCollection()
    {
        $this->validate([
            'collectionName' => 'required|string|max:255',
            'selectedMovies' => 'array',
        ]);

        $collection = auth()->user()->collections()->create([
            'name' => $this->collectionName,
            'is_public' => $this->isPublic,
        ]);

        if (!empty($this->selectedMovies)) {
            $collection->movies()->attach($this->selectedMovies);
        }

        $this->resetForm();
        $this->isEditing = false;

        unset($this->userCollections);

        session()->flash('message', 'Sammlung erfolgreich erstellt!');
    }

    public function viewWatchlist()
    {
        $this->viewingWatchlist = true;
        $this->viewingCollection = null;
        $this->viewingFavorites = false;
        $this->isEditing = false;

        // Загружаем фильмы из watchlist пользователя
        $this->watchlistMovies = auth()->user()->watchlist()->get();
    }

    public function viewFavorites()
    {
        $this->viewingFavorites = true;
        $this->viewingCollection = null;
        $this->viewingWatchlist = false;
        $this->isEditing = false;

        // Загружаем любимые фильмы пользователя
        $this->favoriteMovies = auth()->user()->favoriteMovies()->get();
    }


    public function mount(): void
    {
        $user = auth()->user();
        $settings = $user->settings;

        $this->profileForm = [
            'name' => $user->name ?? '',
            'email' => $user->email ?? '',
            'biography' => $user->biography ?? '',
            'selectedGenres' => $user->favoriteGenres->pluck('id')->toArray(),
            'notifications' => [
                'email_new_movies' => (bool)($settings->email_new_movies ?? false),
                'email_new_recommendations' => (bool)($settings->email_new_recommendations ?? false),
                'email_friends_request' => (bool)($settings->email_friends_request ?? false),
            ]
        ];

        $this->profilePhoto = null;
        $this->searchedUsers = User::query()->inRandomOrder()->paginate(6);
        $this->showAddFriendsPage = false;
    }

    public function render()
    {
        return view('livewire.profile.profile-page');
    }
}
