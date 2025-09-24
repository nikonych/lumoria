@props(['user', 'index'])

<div class="bg-bg-card rounded-md py-5 px-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <div
            class="w-16 h-16 rounded-full overflow-hidden bg-slate-600 flex items-center justify-center">
            @if($user->profile_url)
                <img src="{{ $user->profile_url }}" alt="{{ $user->name }}"
                     class="w-full h-full object-cover">
            @else
                <span
                    class="text-slate-300 font-semibold text-xl">{{ $user->initials() }}</span>
            @endif
        </div>
        <div>
            <h3 class="text-xl text-slate-50">{{ $user->name }}</h3>
            <p class="text-indigo-300 text-sm">
                @php
                    $friendship = \App\Models\Friendship::where(function($query) use ($user) {
                        $query->where('user_id', auth()->id())->where('friend_id', $user->id);
                    })->orWhere(function($query) use ($user) {
                        $query->where('user_id', $user->id)->where('friend_id', auth()->id());
                    })->first();
                @endphp

                @if($friendship)
                    @php
                        $diffInMinutes = floor($friendship->created_at->diffInMinutes(now()));
                        $diffInHours = floor($friendship->created_at->diffInHours(now()));
                        $diffInDays = floor($friendship->created_at->diffInDays(now()));
                        $diffInWeeks = floor($friendship->created_at->diffInWeeks(now()));
                        $diffInMonths = floor($friendship->created_at->diffInMonths(now()));
                    @endphp

                    @if($friendship->user_id === auth()->id() && $friendship->status === 'pending')
                        {{-- Отправленная заявка --}}
                        @if($diffInMinutes < 1)
                            gerade eben angefragt
                        @elseif($diffInMinutes < 60)
                            vor {{ $diffInMinutes == 1 ? '1 Minute' : $diffInMinutes . ' Minuten' }} angefragt
                        @elseif($diffInHours < 24)
                            vor {{ $diffInHours == 1 ? '1 Stunde' : $diffInHours . ' Stunden' }} angefragt
                        @else
                            vor {{ $diffInDays == 1 ? '1 Tag' : $diffInDays . ' Tagen' }} angefragt
                        @endif

                    @elseif($friendship->friend_id === auth()->id() && $friendship->status === 'pending')
                        {{-- Полученная заявка --}}
                        @if($diffInMinutes < 1)
                            gerade eben Anfrage erhalten
                        @elseif($diffInMinutes < 60)
                            vor {{ $diffInMinutes == 1 ? '1 Minute' : $diffInMinutes . ' Minuten' }} Anfrage erhalten
                        @elseif($diffInHours < 24)
                            vor {{ $diffInHours == 1 ? '1 Stunde' : $diffInHours . ' Stunden' }} Anfrage erhalten
                        @else
                            vor {{ $diffInDays == 1 ? '1 Tag' : $diffInDays . ' Tagen' }} Anfrage erhalten
                        @endif

                    @elseif($friendship->status === 'accepted')
                        {{-- Друзья --}}
                        @if($diffInMonths > 0)
                            seit {{ $diffInMonths == 1 ? '1 Monat' : $diffInMonths . ' Monaten' }} befreundet
                        @elseif($diffInWeeks > 0)
                            seit {{ $diffInWeeks == 1 ? '1 Woche' : $diffInWeeks . ' Wochen' }} befreundet
                        @elseif($diffInDays > 0)
                            seit {{ $diffInDays == 1 ? '1 Tag' : $diffInDays . ' Tagen' }} befreundet
                        @else
                            seit heute befreundet
                        @endif
                    @endif
                @else
                    seit {{ $user->created_at->format('Y') }} Mitglied
                @endif
            </p>
        </div>
    </div>
    <div>
        @php
            $friendship = \App\Models\Friendship::where(function($query) use ($user) {
                $query->where('user_id', auth()->id())->where('friend_id', $user->id);
            })->orWhere(function($query) use ($user) {
                $query->where('user_id', $user->id)->where('friend_id', auth()->id());
            })->first();
        @endphp

        @if($friendship && $friendship->user_id === auth()->id() && $friendship->status === 'pending')
            {{-- Отправленная заявка - показываем часы --}}
            <button class="w-12 h-12 rounded-full flex items-center justify-center">
                <x-icons.time/>
            </button>

        @elseif($friendship && $friendship->friend_id === auth()->id() && $friendship->status === 'pending')
            {{-- Полученная заявка - показываем принять/отклонить --}}
            <div class="flex gap-2">
                <button
                    wire:click="acceptFriendRequestByUserId({{ $user->id }})"
                    class="w-12 h-12 bg-green-600 hover:bg-green-700 rounded-full flex items-center justify-center transition-colors duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
                <button
                    wire:click="declineFriendRequestByUserId({{ $user->id }})"
                    class="w-12 h-12 bg-red-600 hover:bg-red-700 rounded-full flex items-center justify-center transition-colors duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

        @elseif($friendship && $friendship->status === 'accepted')
            {{-- Уже друзья - показываем галочку или сердечко --}}
            <button class="w-12 h-12 rounded-full flex items-center justify-center cursor-default">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </button>

        @else
            {{-- Нет связи - показываем кнопку добавить в друзья --}}
            <button
                wire:click="sendFriendRequest({{ $user->id }})"
                class="w-12 h-12 cursor-pointer hover:bg-indigo-900 rounded-full flex items-center justify-center transition-colors duration-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>
        @endif
    </div>
</div>
