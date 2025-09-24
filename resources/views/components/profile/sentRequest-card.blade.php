@props(['request'])

<div class="bg-bg-card rounded-lg p-5 pl-6 flex items-center justify-between">
    <div class="flex">
        <div class="mr-4">
            <div
                class="w-16 h-16 rounded-full overflow-hidden bg-slate-600 flex items-center justify-center flex-shrink-0">
                @if($request->friend->profile_url)
                    <a href="{{ route('user.show', $request->friend) }}" class="block">
                        <img src="{{ $request->friend->profile_url }}" alt="{{ $request->friend->name }}"
                             class="w-full h-full object-cover">
                    </a>
                @else
                    <span
                        class="text-slate-300 text-xl">{{ $request->friend->initials() }}</span>
                @endif
            </div>
        </div>
        <div class="pr-12 space-y-1.5">
            <a href="{{ route('user.show', $request->friend) }}" class="block">
                <p class="text-slate-50 text-lg">{{ $request->friend->name }}</p>
            </a>
            <p class="text-indigo-300 text-sm">Anfrage ausstehend</p>
        </div>
    </div>

    <div class="">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="text-slate-400 hover:text-slate-300 p-1">
                <x-icons.menu/>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition
                 class="absolute right-0 top-8 bg-indigo-950 rounded-md shadow-lg p-2.5 min-w-[250px] z-10">
                <button
                    wire:click="cancelFriendRequest({{ $request->id }})"
                    @click="open = false"
                    class="w-full text-left px-4 py-2 hover:bg-indigo-900 transition-colors duration-200 flex items-center gap-2">
                    <div class="flex justify-between items-center w-full">
                        Anfrage zurückziehen
                        <x-icons.minus/>
                    </div>
                </button>
                <button
                    class="w-full text-left px-4 py-2 hover:bg-indigo-900 transition-colors duration-200 flex items-center gap-2">
                    <div class="flex justify-between items-center w-full">
                        blockieren
                        <x-icons.ban/>
                    </div>
                </button>
            </div>
        </div>
    </div>

</div>
