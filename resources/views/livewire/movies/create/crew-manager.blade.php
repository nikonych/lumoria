<div class="mt-16">
    <p class="text-2xl">Filmstab</p>
    @foreach($crew as $index => $member)
        <div class="flex space-x-5 mt-5 items-end" wire:key="crew-{{ $index }}">
            <div class="w-1/3">
                <label class="block mb-1.5 text-sm text-slate-50">Person</label>
                <livewire:base.search-select
                    wire:model="crew.{{ $index }}.person_id"
                    :options="collect($people)->map(fn($p) => ['value' => $p->id, 'text' => $p->name])->toArray()"
                    class="w-full"
                    wire:key="'select-crew-person-{{$index}}"/>
            </div>
            <div class="w-1/3">
                <label class="block mb-1.5 text-sm text-slate-50">Abteilung</label>
                <livewire:base.selection
                    wire:model="crew.{{ $index}}.department_id"
                    :options="collect($departments)->map(fn($d) => ['value' => $d->id, 'text' => $d->name])->toArray()"
                    class="w-full"
                    wire:key="'select-crew-department-{{$index}}"/>
            </div>
            <div class="w-1/3">
                <x-base.input wire:model="crew.{{ $index }}.position">
                    <x-slot name="label">Position</x-slot>
                </x-base.input>
            </div>
            @if(count($crew) > 1)
                <x-base.button type="button" variant="danger" icon="trash"
                               wire:click.prevent="removeCrewMember('{{ $index }}')"/>
            @else
                @if(!empty($member['person_id']) || !empty($member['department_id']) || !empty($member['position']))
                    <x-base.button type="button" variant="danger" icon="trash"
                                   wire:click.prevent="clearCrewMember('{{ $index }}')"/>
                @endif
            @endif
        </div>
    @endforeach
    <x-base.button type="button" icon="plus" class="mt-5" wire:click.prevent="addCrewMember">
        Weiteres Mitglied hinzufügen
    </x-base.button>
</div>
