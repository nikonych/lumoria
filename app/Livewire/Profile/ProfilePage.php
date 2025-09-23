<?php

namespace App\Livewire\Profile;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ProfilePage extends Component
{
    use WithPagination;

    public $activeTab = 'einstellungen';
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

    // Добавляем свойства для смены пароля
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
        return auth()->user()->collections()->withCount('movies')->with(['movies' => function($query) {
            $query->select('movies.id', 'movies.poster_image')->limit(1);
        }])->get();
    }

    #[Computed]
    public function genres()
    {
        return Genre::orderBy('name')->get();
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
    }

    public function cancelEdit(): void
    {
        $this->isEditing = false;
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
        $this->isEditing = false;
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
        $this->viewingCollection = null;
        $this->isEditingCollection = false;
        $this->resetForm();
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
    }

    public function render()
    {
        return view('livewire.profile.profile-page');
    }
}
