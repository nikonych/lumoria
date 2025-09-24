<x-layouts.app-profile>
    <div class="flex w-full mt-32 bg-slate-950 space-x-12">
        <div class="w-1/4 ml-24">
            <div class="sticky top-32 flex flex-col h-[calc(100vh-14rem)]">
                <div class="flex-shrink-0">
                    <img src="{{ $user->profile_url }}" alt="{{ $user->name }}" class="rounded-full w-32 h-32 -mt-16">
                </div>

                <div class="flex-1 overflow-y-auto">
                    <p class="text-5xl font-family-helvetica mt-7">{{ explode(' ', $user->name)[0] }}</p>
                    <p class="text-indigo-300 mt-3 text-lg">
                        seit {{ $user->created_at->format('Y') }} Mitglied
                    </p>
                    <p class="font-extralight mt-3 text-sm">
                        {{ $user->biography }}
                    </p>
                    <div class="flex items-center space-x-2.5 mt-8">
                        @foreach($user->favoriteGenres as $genre)
                            <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-xs">
                            {{ $genre->name }}
                        </span>
                        @endforeach
                    </div>
                    <div class="flex space-x-4 items-end mt-3.5">
                        <p class="text-indigo-600 text-3xl">
                            {{ $user->ratings()->count() }}
                        </p>
                        <p class="font-extralight text-sm mb-0.5">
                            Bewertungen
                        </p>
                    </div>
                </div>

                {{-- Кнопка действий с друзьями --}}
                <div class="flex-shrink-0 mb-8">
                    <livewire:user.friend-actions :user="$user"/>
                </div>
            </div>
        </div>
        <div class="w-3/4">
            <livewire:user.user-profile-page :user="$user"/>
        </div>
    </div>
</x-layouts.app-profile>
