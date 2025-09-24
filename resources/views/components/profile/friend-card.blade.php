@props(['friend'])

<div class="bg-bg-card rounded-xl p-5 px-6 flex space-x-5 items-center justify-between">
    <div class="flex items-center gap-4">

        <div
            class="w-16 h-16 rounded-full overflow-hidden bg-slate-600 flex items-center justify-center flex-shrink-0">
            @if($friend->profile_url)
                <a href="{{ route('user.show', $friend) }}" class="block">
                    <img src="{{ $friend->profile_url }}" alt="{{ $friend->name }}"
                         class="w-full h-full object-cover">
                </a>
            @else
                <span
                    class="text-slate-300 text-xl">{{ $friend->initials() }}</span>
            @endif
        </div>

        <div class="flex-1">
            <a href="{{ route('user.show', $friend) }}" class="block">
                <h3 class="text-lg text-slate-50">{{ $friend->name }}</h3>
            </a>
            <p class="text-indigo-300 font-light text-sm">
                @php
                    $friendship = \App\Models\Friendship::where(function($query) use ($friend) {
                        $query->where('user_id', auth()->id())->where('friend_id', $friend->id);
                    })->orWhere(function($query) use ($friend) {
                        $query->where('user_id', $friend->id)->where('friend_id', auth()->id());
                    })->first();

                    if ($friendship) {
                        $diffInDays = floor($friendship->created_at->diffInDays(now()));
                        $diffInWeeks = floor($friendship->created_at->diffInWeeks(now()));
                        $diffInMonths = floor($friendship->created_at->diffInMonths(now()));
                    } else {
                        $diffInDays = $diffInWeeks = $diffInMonths = 0;
                    }
                @endphp

                @if($friendship)
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
            </p>
        </div>
    </div>

    <div class="">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="text-slate-400 hover:text-slate-300 p-1">
                <x-icons.menu/>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition
                 class="absolute right-0 top-8 bg-indigo-950 rounded-md shadow-lg p-2.5 min-w-[210px] z-10">
                <button
                    wire:click="removeFriend({{ $friend->pivot->id ?? $friend->id }})"
                    @click="open = false"
                    class="w-full text-left px-4 py-2 hover:bg-indigo-900 transition-colors duration-200 flex items-center gap-2">
                    <div class="flex justify-between items-center w-full">
                        Freund entfernen
                        <x-icons.minus/>
                    </div>
                </button>
                <button
                    class="w-full text-left px-4 py-2 hover:bg-indigo-900 transition-colors duration-200 flex items-center gap-2">
                    <div class="flex justify-between items-center w-full">
                        Freund blockieren
                        <x-icons.ban/>
                    </div>
                </button>
            </div>
        </div>
    </div>

</div>
