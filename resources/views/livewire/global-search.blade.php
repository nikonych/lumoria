<div class="relative" x-data="searchComponent()" @click.outside="closeResults()">
    <x-base.input
        wire:model.live="searchQuery"
        wire:key="search-input"
        @focus="openResults()"
        @keydown.escape="closeResults()"
        :has-icon="true"
        class="w-3xs"
        placeholder="Suche..."
        autocomplete="off"
        x-ref="searchInput"
    />

    <!-- Результаты поиска -->
    <div
        x-show="showDropdown"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute top-full right-0 mt-2 w-96 bg-indigo-950 rounded-lg shadow-xl z-50 max-h-96 overflow-y-auto"
        style="display: none;"
    >
        <!-- Фильмы -->
        @if(count($movies) > 0)
            <div class="px-4 py-2">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Filme</h3>
            </div>
            @foreach($movies as $movie)
                <div
                    @click="selectResult('movie', {{ $movie->id }})"
                    class="flex items-center px-4 py-3 hover:bg-indigo-900 cursor-pointer border-b border-slate-700 last:border-b-0"
                >
                    <div class="flex-shrink-0 w-12 h-16 mr-3">
                        @if($movie->poster_image)
                            <img src="{{ $movie->poster_image }}" alt="{{ $movie->title }}"
                                 class="w-full h-full object-cover rounded">
                        @else
                            <div class="w-full h-full bg-slate-600 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v1a1 1 0 01-1 1H3a1 1 0 01-1-1V5a1 1 0 011-1h4z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 8v12a2 2 0 002 2h10a2 2 0 002-2V8"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ $movie->title }}</p>
                        <p class="text-xs text-slate-400">
                            {{ $movie->release_year }}
                        </p>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Персоны -->
        @if(count($people) > 0)
            @if(count($movies) > 0)
                <div class="border-t border-slate-600"></div>
            @endif
            <div class="px-4 py-2">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Personen</h3>
            </div>
            @foreach($people as $person)
                <div
                    @click="selectResult('person', {{ $person->id }})"
                    class="flex items-center px-4 py-3 hover:bg-slate-700 cursor-pointer border-b border-slate-700 last:border-b-0"
                >
                    <div class="flex-shrink-0 w-10 h-10 mr-3">
                        @if($person->profile_image)
                            <img src="{{ $person->profile_image }}" alt="{{ $person->name }}"
                                 class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-indigo-900 flex items-center justify-center">
                                <span class="text-indigo-200 text-sm font-medium">
                                    {{ strtoupper(substr($person->name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ $person->name }}</p>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Нет результатов -->
        @if(count($movies) === 0 && count($people) === 0 && strlen($searchQuery) >= 2)
            <div class="px-4 py-6 text-center">
                <p class="text-sm text-slate-400">Keine Ergebnisse für "{{ $searchQuery }}"</p>
            </div>
        @endif


    </div>
</div>

<script>
    function searchComponent() {
        return {
            showDropdown: false,

            init() {
                this.$wire.$watch('searchQuery', (value) => {
                    if (value && value.length >= 2) {
                        this.showDropdown = true;
                    } else {
                        this.showDropdown = false;
                    }
                });
            },

            openResults() {
                if (this.$wire.searchQuery && this.$wire.searchQuery.length >= 2) {
                    this.showDropdown = true;
                }
            },

            closeResults() {
                this.showDropdown = false;
            },

            selectResult(type, id) {
                this.showDropdown = false;
                this.$wire.selectResult(type, id);
            }
        }
    }
</script>
