<div class="flex flex-col space-y-12">
    <div class="space-y-12">
        <div class="flex justify-between">
            <p class="text-3xl">{{ $user->name }}s Sammlungen</p>
        </div>

        <div class="grid grid-cols-3 gap-x-5 gap-y-5">
            {{-- Показываем только публичные коллекции --}}
            @foreach($this->userCollections as $collection)
                <div class="cursor-pointer" wire:click="viewCollection({{ $collection->id }})">
                    <x-profile.media-card
                        :title="$collection->name"
                        :image-url="$collection->movies->first()?->poster_url ?? Vite::asset('resources/images/no_movie.svg')"
                        :count="$collection->movies_count"
                        :is-public="$collection->is_public"
                    />
                </div>
            @endforeach

            @if($this->userCollections->isEmpty())
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-400 text-lg">Keine öffentlichen Sammlungen vorhanden</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Collection View (без возможности редактирования) --}}
    @if($viewingCollection)
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
                        wire:click="backToCollections"
                    >
                        Zurück
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
        </div>
    @endif
</div>
