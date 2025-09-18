<div class="mt-16">
    <p class="text-2xl">Besetzung</p>
    @foreach($cast as $index => $actor)
        <div class="flex space-x-5 mt-5 items-end" wire:key="actor-{{ $index }}">
            <div class="w-1/2">
                <label class="block mb-1.5 text-sm text-slate-50">Schauspieler:in</label>
                <livewire:base.search-select
                    wire:model.live="cast.{{ $index }}.person_id"
                    :options="collect($people)->map(fn($p) => ['value' => $p->id, 'text' => $p->name])->toArray()"
                    class="w-full"
                    wire:key="select-{{ $index }}"/>
            </div>
            <div class="w-1/2">
                <x-base.input wire:model.blur="cast.{{ $index }}.role_name">
                    <x-slot name="label">Rolle</x-slot>
                </x-base.input>
            </div>
            @if(count($cast) > 1)
                <x-base.button type="button" variant="danger" icon="trash"
                               wire:click.prevent="removeActor('{{$index }}')"/>
            @else
                @if(!empty($actor['person_id']) || !empty($actor['role_name']))
                    <x-base.button type="button" variant="danger" icon="trash"
                                   wire:click.prevent="clearActor('{{ $index }}')"/>
                @endif
            @endif
        </div>
    @endforeach
    <x-base.button type="button" icon="plus" class="mt-5" wire:click.prevent="addActor">
        Weitere Schauspieler:innen hinzufügen
    </x-base.button>
</div>
