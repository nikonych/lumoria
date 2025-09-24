<div class="flex flex-col space-y-12">

    @if(!$isEditing && !$viewingCollection && !$viewingWatchlist && !$viewingFavorites)
        <div class="space-y-12">
            <div class="flex justify-between">
                <p class="text-3xl">Deine Sammlungen</p>
                <x-base.button icon="plus" wire:click="toggleEdit">
                    Sammlung hinzufügen
                </x-base.button>
            </div>

            <div class="grid grid-cols-3 gap-x-5 gap-y-5">
                <div wire:click="viewWatchlist" class="cursor-pointer">
                    <x-profile.media-card
                        title="Watchlist"
                        :image-url="Vite::asset('resources/images/movies/shawshank.png')"
                        :count="auth()->user()->watchlist()->count()"
                    />
                </div>

                <div wire:click="viewFavorites" class="cursor-pointer">
                    <x-profile.media-card
                        title="Favoriten"
                        :image-url="Vite::asset('resources/images/movies/theory.png')"
                        :count="auth()->user()->favoriteMovies()->count()"
                    />
                </div>

                @foreach($this->userCollections as $collection)
                    <div wire:click="viewCollection({{ $collection->id }})" class="cursor-pointer">
                        <x-profile.media-card
                            :title="$collection->name"
                            :image-url="$collection->movies->first()?->poster_url ?? Vite::asset('resources/images/no_movie.svg')"
                            :count="$collection->movies_count"
                            :is-public="$collection->is_public"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Watchlist View --}}
    @if($viewingWatchlist)
        <div class="space-y-12">
            <p class="text-indigo-400 text-sm">
                <a wire:click="backToCollections" class="font-light cursor-pointer">Listen</a> /
                <span class="font-semibold">Watchlist</span>
            </p>

            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <p class="text-3xl font-family-helvetica">Watchlist</p>
                    <span class="text-lg text-gray-400">({{ $watchlistMovies->count() }} Filme)</span>
                </div>
                <x-base.button
                    type="button"
                    variant="secondary"
                    wire:click="backToCollections"
                >
                    Zurück
                </x-base.button>
            </div>

            @if($watchlistMovies->count() > 0)
                <div class="grid grid-cols-6 gap-x-4 gap-y-4">
                    @foreach($watchlistMovies as $movie)
                        <div class="relative group">
                            <x-profile.card-mini :movie="$movie" :show-checkbox="false"/>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-400 text-lg">Ihre Watchlist ist leer</p>
                    <p class="text-gray-500 mt-2">Fügen Sie Filme zu Ihrer Watchlist hinzu, um sie hier zu sehen.</p>
                </div>
            @endif
        </div>
    @endif

    {{-- Favorites View --}}
    @if($viewingFavorites)
        <div class="space-y-12">
            <p class="text-indigo-400 text-sm">
                <a wire:click="backToCollections" class="font-light cursor-pointer">Listen</a> /
                <span class="font-semibold">Favoriten</span>
            </p>

            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <p class="text-3xl font-family-helvetica">Favoriten</p>
                    <span class="text-lg text-gray-400">({{ $favoriteMovies->count() }} Filme)</span>
                </div>
                <x-base.button
                    type="button"
                    variant="secondary"
                    wire:click="backToCollections"
                >
                    Zurück
                </x-base.button>
            </div>

            @if($favoriteMovies->count() > 0)
                <div class="grid grid-cols-6 gap-4">
                    @foreach($favoriteMovies as $movie)
                        <div class="relative group">
                            <x-profile.card-mini :movie="$movie" :show-checkbox="false"/>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-400 text-lg">Ihre Favoriten sind leer</p>
                    <p class="text-gray-500 mt-2">Fügen Sie Filme zu Ihren Favoriten hinzu, um sie hier zu sehen.</p>
                </div>
            @endif
        </div>
    @endif

    {{-- Custom Collection View --}}
    @if($viewingCollection && !$isEditingCollection)
        <div class="space-y-12">
            <p class="text-indigo-400 text-sm">
                <a wire:click="backToCollections" class="font-light cursor-pointer">Listen</a> /
                <span class="font-semibold cursor-pointer">{{$viewingCollection->name}}</span>
            </p>

            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <p class="text-3xl font-family-helvetica">{{$viewingCollection->name}}</p>
                </div>
                <div class="flex space-x-3">
                    <x-base.button
                        type="button"
                        variant="secondary"
                        wire:click="editCollection"
                    >
                        Bearbeiten
                    </x-base.button>
                    <x-base.button
                        type="button"
                        variant="danger"
                        icon="trash"
                        wire:click="deleteCollection"
                        wire:confirm="Sind Sie sicher, dass Sie diese Sammlung löschen möchten?"
                    >
                        Löschen
                    </x-base.button>
                </div>
            </div>

            <div class="grid grid-cols-6">
                @foreach($viewingCollection->movies as $movie)
                    <div class="relative group">
                        <x-profile.card-mini :movie="$movie" :show-checkbox="false"/>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center">
                <x-base.button
                    type="button"
                    variant="primary"
                    icon="plus"
                    wire:click="openAddMoviesModal"
                >
                    Film hinzufügen
                </x-base.button>
            </div>
        </div>
    @endif

    {{-- Edit Collection View --}}
    @if($viewingCollection && $isEditingCollection)
        <div class="space-y-12">
            <div class="flex justify-between items-center">
                <p class="text-3xl">Sammlung bearbeiten</p>
                <div class="flex space-x-3">
                    <x-base.button
                        type="button"
                        variant="success"
                        icon="save"
                        wire:click="updateCollection"
                        :disabled="empty(trim($collectionName))"
                    >
                        Speichern
                    </x-base.button>
                    <x-base.button
                        type="button"
                        variant="secondary"
                        wire:click="isEditingCollection = false"
                    >
                        Abbrechen
                    </x-base.button>
                </div>
            </div>

            <div class="flex items-end space-x-5">
                <div class="w-1/2">
                    <label for="editCollectionName" class="block text-sm mb-2">
                        Listenname
                    </label>
                    <x-base.input
                        type="text"
                        id="editCollectionName"
                        wire:model="collectionName"
                        wire:key="edit-collection-name-input"
                    />
                </div>
                <div class="w-1/2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input
                            type="checkbox"
                            wire:model="isPublic"
                            class="sr-only peer"
                        >
                        <div class="relative w-11 h-6 bg-input-dark/85 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-700"></div>
                        <span class="ml-3.5 text-xs font-extralight text-indigo-50">Sammlung öffentlich zugänglich machen</span>
                    </label>
                </div>
            </div>
        </div>
    @endif

    @if($isEditing && !$viewingCollection)
        <div class="space-y-12">
            <div class="flex justify-between items-center">
                <p class="text-3xl font-family-helvetica">Neue Sammlung</p>
                <div class="flex space-x-3">
                    <x-base.button
                        type="button"
                        variant="success"
                        icon="save"
                        wire:click="saveCollection"
                        :disabled="empty(trim($collectionName))"
                    >
                        Speichern
                    </x-base.button>
                    <x-base.button
                        type="button"
                        variant="secondary"
                        wire:click="cancelEdit"
                    >
                        Abbrechen
                    </x-base.button>
                </div>
            </div>

            <div class="">
                <div class="flex items-end space-x-5">
                    <div class="w-1/2">
                        <label for="collectionName" class="block text-sm mb-2">
                            Listenname
                        </label>
                        <x-base.input
                            type="text"
                            id="collectionName"
                            wire:model="collectionName"
                            wire:key="collection-name-input"
                        />
                    </div>
                    <div class="w-1/2">
                        <label class="inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                wire:model="isPublic"
                                class="sr-only peer"
                            >
                            <div class="relative w-22 h-6 bg-input-dark/85 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-700"></div>
                            <span class="ml-3.5 text-xs font-extralight text-indigo-50">Sammlung öffentlich zugänglich machen. Dadurch können Freunde und andere Nutzer sie sehen. Du kannst diese Einstellung jederzeit ändern.</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-between mt-8 space-x-5">
                    <div class="flex-1">
                        <x-base.input
                            wire:model.live="searchQuery"
                            wire:key="search-input"
                            :has-icon="true"
                            placeholder="Suche..."
                        />
                    </div>
                </div>

                <div class="mt-5">
                    <x-carousel-pagination-new :items="$this->movies" :per-page="5">
                        <div class="flex scrollbar-hide overflow-x-auto scroll-smooth snap-x snap-mandatory space-x-5">
                            @foreach($this->movies as $movie)
                                <div class="flex-shrink-0 w-1/2 sm:w-1/4 md:w-1/3 lg:w-1/7" wire:key="movie-{{ $movie->id }}">
                                    <x-profile.card-mini :movie="$movie"/>
                                </div>
                            @endforeach
                        </div>
                    </x-carousel-pagination-new>
                </div>
            </div>
        </div>
    @endif

    @if($showAddMoviesModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeAddMoviesModal">
            <div class="bg-gray-800 rounded-lg p-6 max-w-4xl w-full max-h-[80vh] overflow-y-auto" wire:click.stop>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl text-white">Filme hinzufügen</h2>
                    <button wire:click="closeAddMoviesModal" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mb-6">
                    <x-base.input
                        wire:model.live="modalSearchQuery"
                        wire:key="modal-search-input"
                        :has-icon="true"
                        placeholder="Filme suchen..."
                    />
                </div>

                <div class="grid grid-cols-4 gap-4 mb-6">
                    @foreach($this->modalMovies as $movie)
                        <div wire:key="modal-movie-{{ $movie->id }}">
                            <div class="relative">
                                <x-profile.card-mini :movie="$movie" :show-checkbox="false"/>
                                <div class="absolute top-2 right-2">
                                    <div wire:click="toggleModalMovieSelection({{ $movie->id }})" class="cursor-pointer">
                                        <x-base.checkbox-big
                                            :checked="in_array($movie->id, $modalSelectedMovies)"
                                            wire:key="modal-checkbox-{{ $movie->id }}"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $this->modalMovies->links() }}

                <div class="flex justify-end space-x-3 mt-6">
                    <x-base.button
                        type="button"
                        variant="secondary"
                        wire:click="closeAddMoviesModal"
                    >
                        Abbrechen
                    </x-base.button>
                    <x-base.button
                        type="button"
                        variant="success"
                        wire:click="addMoviesToCollection"
                        :disabled="empty($modalSelectedMovies)"
                    >
                        Hinzufügen ({{ count($modalSelectedMovies) }})
                    </x-base.button>
                </div>
            </div>
        </div>
    @endif
</div>
