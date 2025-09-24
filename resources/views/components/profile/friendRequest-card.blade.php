@props(['request'])

<div class="bg-bg-card rounded-lg p-5 pl-6 flex items-center justify-between">
    <div class="flex">

        <div class="mr-4">
            <div
                class="w-16 h-16 rounded-full overflow-hidden bg-slate-600 flex items-center justify-center flex-shrink-0">
                @if($request->user->profile_url)
                    <a href="{{ route('user.show', $request->user) }}" class="block">
                        <img src="{{ $request->user->profile_url }}" alt="{{ $request->user->name }}"
                             class="w-full h-full object-cover">
                    </a>
                @else
                    <span
                        class="text-slate-300 text-xl">{{ $request->user->initials() }}</span>
                @endif
            </div>
        </div>
        <div class="pr-12 space-y-1.5">
            <a href="{{ route('user.show', $request->user) }}" class="block">
                <p class="text-slate-50 text-lg">{{ $request->user->name }}</p>
            </a>
            <p class="text-indigo-300 text-sm">Hat dir eine Anfrage gesendet</p>
        </div>
    </div>

    <div class="flex gap-3">
        <x-base.button
            variant="danger"
            icon="no"
            wire:click="declineFriendRequest({{ $request->id }})"
        />
        <x-base.button
            variant="success"
            icon="check"
            wire:click="acceptFriendRequest({{ $request->id }})"
        />
    </div>
</div>
