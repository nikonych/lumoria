<div class="flex mt-8 space-x-10">
    <div class="w-3/12 p-6">
        <div class="flex items-center space-x-2.5 pb-4">
            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 2.39062C0 1.49219 0.703125 0.75 1.60156 0.75H18.3594C19.2578 0.75 20 1.49219 20 2.39062C20 2.78125 19.8438 3.13281 19.6094 3.40625L13.125 11.4141V17C13.125 17.7031 12.5391 18.25 11.8359 18.25C11.5625 18.25 11.2891 18.1719 11.0547 17.9766L7.46094 15.125C7.07031 14.8125 6.875 14.3828 6.875 13.9141V11.4141L0.351562 3.40625C0.117188 3.13281 0 2.78125 0 2.39062ZM2.10938 2.625L8.51562 10.4766C8.67188 10.6719 8.75 10.8672 8.75 11.0625V13.7578L11.25 15.75V11.0625C11.25 10.8672 11.2891 10.6719 11.4453 10.4766L17.8516 2.625H2.10938Z"
                    fill="#F8FAFC"/>
            </svg>
            <p class="text-xl font-semibold">Filter</p>
        </div>

        <div class="space-y-6 mt-4">
            <div>
                <label for="country" class="block text-sm font-medium">Produktionsland</label>
                <livewire:base.selection
                    wire:model.live="countryId"
                    :options="$countries->map(fn($c) => ['value' => $c->id, 'text' => $c->name])->toArray()"
                    label="Alle Länder"
                    class="w-full"
                />
            </div>

            <div>
                <label class="block text-sm font-medium">Erscheinungsjahr</label>
                <div class="flex items-center gap-2 mt-1">
                    <x-base.input
                        type="number"
                        min="1888" {{-- Год первого фильма --}}
                        max="{{ date('Y') }}" {{-- Текущий год --}}
                        class="w-full"
                        wire:model.live="yearFrom"
                    />
                    <span>-</span>
                    <x-base.input
                        type="number"
                        min="1888"
                        max="{{ date('Y') }}"
                        class="w-full"
                        wire:model.live="yearTo"
                    />
                </div>
            </div>

            <div>
                <h4 class="text-sm font-medium">Altersfreigabe</h4>
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-2">
                    @foreach($ageRatings as $rating)
                        <div class="flex items-center">
                            <x-base.checkbox
                                wire:model.live="selectedAgeRatings"
                                value="{{ $rating }}"
                                label="{{ $rating }}"
                                id="age-rating-{{ $loop->index }}"
                            />
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="text-sm font-medium">Genre</h4>
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-2">
                    @foreach($genres as $genre)
                        <div class="flex items-center">
                            <x-base.checkbox
                                wire:model.live="selectedGenres"
                                value="{{ $genre->id }}"
                                label="{{ $genre->name }}"
                                id="genre-{{ $loop->index }}"
                            />
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="text-sm font-medium text-gray-300">Bewertungen</h4>
                <div class="space-y-2 mt-2">
                    <x-base.radio-with-stars
                        wire:model.live="selectedRating"
                        value="4"
                        label="4 und mehr"
                        :stars="4"
                        id="rating-4-stars"
                    />

                    <x-base.radio-with-stars
                        wire:model.live="selectedRating"
                        value="3"
                        label="3 und mehr"
                        :stars="3"
                        id="rating-3-stars"
                    />

                    <x-base.radio-with-stars
                        wire:model.live="selectedRating"
                        value="2"
                        label="2 und mehr"
                        :stars="2"
                        id="rating-2-stars"
                    />
                    <x-base.radio-with-stars
                        wire:model.live="selectedRating"
                        value="1"
                        label="1 und mehr"
                        :stars="1"
                        id="rating-1-stars"
                    />
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button wire:click="resetFilters"
                        class="w-full bg-gray-600/50 hover:bg-gray-500/50 text-white font-semibold py-2 px-4 rounded-md transition-colors">
                    Zurücksetzen
                </button>
                <button
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition-colors">
                    Anwenden
                </button>
            </div>
        </div>
    </div>
    <div class="w-9/12">
        <div class="flex justify-between items-end">
            <h2 class="text-5xl">{{$title}}</h2>
            <div class="flex gap-1.5 items-center">
                <p class="">Sortieren nach</p>

                <livewire:base.selection
                    wire:model.live="sortBy"
                    :options="$sortOptions"
                    :select-first="true"
                    class="w-40"
                />

                <div class="flex items-center p-0.5 ml-3.5 bg-input-dark rounded-sm gap-1">
                    <button wire:click="setView('grid')"
                            @class([
                                'p-2 rounded-xs',
                                'bg-indigo-600 text-white' => $viewMode === 'grid',
                                'text-indigo-400 hover:bg-slate-700' => $viewMode !== 'grid',
                            ])>
                        <svg width="12" height="12" viewBox="0 0 11 11" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 1.375C0 0.765625 0.492188 0.25 1.125 0.25H3.375C3.98438 0.25 4.5 0.765625 4.5 1.375V3.625C4.5 4.25781 3.98438 4.75 3.375 4.75H1.125C0.492188 4.75 0 4.25781 0 3.625V1.375ZM1.125 3.625H3.375V1.375H1.125V3.625ZM0 7.375C0 6.76562 0.492188 6.25 1.125 6.25H3.375C3.98438 6.25 4.5 6.76562 4.5 7.375V9.625C4.5 10.2578 3.98438 10.75 3.375 10.75H1.125C0.492188 10.75 0 10.2578 0 9.625V7.375ZM1.125 9.625H3.375V7.375H1.125V9.625ZM9.375 0.25C9.98438 0.25 10.5 0.765625 10.5 1.375V3.625C10.5 4.25781 9.98438 4.75 9.375 4.75H7.125C6.49219 4.75 6 4.25781 6 3.625V1.375C6 0.765625 6.49219 0.25 7.125 0.25H9.375ZM9.375 1.375H7.125V3.625H9.375V1.375ZM6 7.375C6 6.76562 6.49219 6.25 7.125 6.25H9.375C9.98438 6.25 10.5 6.76562 10.5 7.375V9.625C10.5 10.2578 9.98438 10.75 9.375 10.75H7.125C6.49219 10.75 6 10.2578 6 9.625V7.375ZM7.125 9.625H9.375V7.375H7.125V9.625Z"
                                />
                        </svg>
                    </button>
                    <button wire:click="setView('list')"
                            @class([
                                'p-2 rounded-xs',
                                'bg-indigo-600 text-white' => $viewMode === 'list',
                                'text-indigo-400 hover:bg-slate-700' => $viewMode !== 'list',
                            ])>
                        <svg width="12" height="12" viewBox="0 0 12 11" fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.0625 0.625C2.36719 0.625 2.625 0.882812 2.625 1.1875V2.3125C2.625 2.64062 2.36719 2.875 2.0625 2.875H0.9375C0.609375 2.875 0.375 2.64062 0.375 2.3125V1.1875C0.375 0.882812 0.609375 0.625 0.9375 0.625H2.0625ZM11.4375 1.1875C11.7422 1.1875 12 1.44531 12 1.75C12 2.07812 11.7422 2.3125 11.4375 2.3125H4.3125C3.98438 2.3125 3.75 2.07812 3.75 1.75C3.75 1.44531 3.98438 1.1875 4.3125 1.1875H11.4375ZM11.4375 4.9375C11.7422 4.9375 12 5.19531 12 5.5C12 5.82812 11.7422 6.0625 11.4375 6.0625H4.3125C3.98438 6.0625 3.75 5.82812 3.75 5.5C3.75 5.19531 3.98438 4.9375 4.3125 4.9375H11.4375ZM11.4375 8.6875C11.7422 8.6875 12 8.94531 12 9.25C12 9.57812 11.7422 9.8125 11.4375 9.8125H4.3125C3.98438 9.8125 3.75 9.57812 3.75 9.25C3.75 8.94531 3.98438 8.6875 4.3125 8.6875H11.4375ZM0.375 4.9375C0.375 4.63281 0.609375 4.375 0.9375 4.375H2.0625C2.36719 4.375 2.625 4.63281 2.625 4.9375V6.0625C2.625 6.39062 2.36719 6.625 2.0625 6.625H0.9375C0.609375 6.625 0.375 6.39062 0.375 6.0625V4.9375ZM2.0625 8.125C2.36719 8.125 2.625 8.38281 2.625 8.6875V9.8125C2.625 10.1406 2.36719 10.375 2.0625 10.375H0.9375C0.609375 10.375 0.375 10.1406 0.375 9.8125V8.6875C0.375 8.38281 0.609375 8.125 0.9375 8.125H2.0625Z"
                                />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <div @class([
                        'space-y-4' => $viewMode === 'list',
                        'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8' => $viewMode === 'grid',
                ])>
                @foreach($movies as $movie)
                    @if ($viewMode === 'grid')
                        <x-movies.card :movie="$movie"/>
                    @else
                        <x-movies.card-list :movie="$movie"/>
                    @endif
                @endforeach
            </div>
            <div class="mt-10">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</div>
