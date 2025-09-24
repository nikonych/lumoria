<div>
    @if($this->friendship && $this->friendship->status === 'accepted')
        <x-base.button icon="minus" variant="secondary"
                       wire:click="removeFriend"
                       wire:confirm="Möchten Sie diese Freundschaft wirklich beenden?">
            Freund entfernen
        </x-base.button>
    @elseif(auth()->id() !== $this->user->id)
        <div class="text-center text-gray-400">
            <p class="text-sm">Ihr seid nicht befreundet</p>
        </div>
    @endif
</div>
