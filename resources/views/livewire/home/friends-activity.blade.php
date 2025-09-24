<div>
    <p class="text-2xl">Aktivität deiner Freunde</p>

    <div class="mt-9 space-y-5 text-lg">
        @foreach($activities as $activity)
            @php $displayData = $activity->getDisplayData(); @endphp

            @if($activity->activity_type === 'movie_rated')
                <div class="bg-bg-card p-6 rounded-md">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full overflow-hidden bg-slate-600 flex items-center justify-center flex-shrink-0">
                                @if($displayData['movie_poster'])
                                    <a href="/movies/{{ $displayData['movie_id'] }}" class="block">
                                        <img src="{{ $displayData['movie_poster'] }}" alt="{{ $displayData['movie_title'] }}"
                                             class="w-full h-full object-cover">
                                    </a>
                                @else
                                    <span
                                        class="text-slate-300 text-xl">{{ $displayData['movie_title'] }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-lg text-indigo-200">{{ $displayData['movie_title'] }}</p>
                                <p class="text-sm font-light">von <span
                                        class="cursor-pointer font-medium">{{ $activity->user->name }}</span></p>
                            </div>
                        </div>
                        <x-base.stars rating="{{ $displayData['rating'] }}" size="4" spacing="space-x-2"/>
                    </div>

                    <div class="border-b border-y-indigo-950 mt-3.5"></div>

                    <div class="mt-2.5">
                        <h3 class="text-lg text-indigo-200">{{ $displayData['review_title'] }}</h3>
                        <p class="text-sm font-light line-clamp-2 mt-2.5">
                            {{ $displayData['review_content'] }}
                        </p>
                    </div>
                </div>

            @elseif($activity->activity_type === 'friend_request_sent'
                    && $displayData['target_user_id'] === auth()->id())
                @php
                    $currentFriendship = \App\Models\Friendship::find($displayData['friendship_id']);
                    $isPending = $currentFriendship && $currentFriendship->status === 'pending';
                @endphp
                <div class="space-y-1 bg-bg-card p-6 rounded-md">
                    <p><span class="cursor-pointer text-indigo-200">{{ $activity->user->name }}</span> hat dir eine
                        Freundschaftsanfrage gesendet</p>
                    <p class="text-sm font-light">{{ $activity->created_at->diffForHumans() }}</p>
                    @if($isPending)
                        <div class="flex w-full justify-between gap-4">
                            <x-base.button
                                wire:click="declineFriendRequest({{ $displayData['friendship_id'] }})"
                                variant="secondary"
                                class="w-1/2"
                            >
                                Ablehnen
                            </x-base.button>
                            <x-base.button
                                wire:click="acceptFriendRequest({{ $displayData['friendship_id'] }})"
                                class="w-1/2"
                            >
                                Akzeptieren
                            </x-base.button>
                        </div>
                    @else
                        <div class="mt-2">
                            @if($currentFriendship && $currentFriendship->status === 'accepted')
                                <p class="text-green-400 text-sm">✓ Freundschaft angenommen</p>
                            @elseif($currentFriendship && $currentFriendship->status === 'declined')
                                <p class="text-red-400 text-sm">✗ Freundschaft abgelehnt</p>
                            @else
                                <p class="text-gray-400 text-sm">Freundschaftsanfrage nicht mehr verfügbar</p>
                            @endif
                        </div>
                    @endif
                </div>

            @else
                <div class="space-y-1 bg-bg-card p-6 rounded-md">
                    <p>
                        @php
                            $userLink = '<a href="' . route('user.show', $activity->user) . '" class="cursor-pointer text-indigo-200 hover:text-indigo-100 transition-colors">' . $activity->user->name . '</a>';
                            $message = str_replace('{user}', $userLink, $displayData['message']);

                            if (isset($displayData['movie_title']) && isset($displayData['movie_id'])) {
                                $movieLink = '<a href="' . route('movies.details', $displayData['movie_id']) . '" class="cursor-pointer text-indigo-200 hover:text-indigo-100 transition-colors">' . $displayData['movie_title'] . '</a>';
                                $message = str_replace('{movie}', $movieLink, $message);
                            }

                            if (isset($displayData['person_name']) && isset($displayData['person_id'])) {
                                $personLink = '<a href="' . route('people.details', $displayData['person_id']) . '" class="cursor-pointer text-indigo-200 hover:text-indigo-100 transition-colors">' . $displayData['person_name'] . '</a>';
                                $message = str_replace('{person}', $personLink, $message);
                            }
                        @endphp
                        {!! $message !!}
                    </p>
                    <p class="text-sm font-light">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
            @endif
        @endforeach
    </div>
</div>
