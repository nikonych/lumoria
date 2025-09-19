<div class="mt-16">
    <p class="text-2xl">Filmstab</p>
    @foreach($crew as $member)
        <div class="flex space-x-5 mt-5 items-center" wire:key="crew-{{ $member['id'] }}">
            <div class="w-1/3">
                <x-form.select-field
                    name="form.crew.{{ $member['id'] }}.person_id"
                    label="Person"
                    wire-model="form.crew.{{ $member['id'] }}.person_id"
                    :options="$this->people"
                    type="search-select-with-add"
                    :model-class="\App\Models\Person::class"
                    model-create-field="name"
                />
            </div>
            <div class="w-1/3">
                <x-form.select-field
                    name="form.crew.{{ $member['id']}}.department_id"
                    label="Abteilung"
                    wire-model="form.crew.{{ $member['id'] }}.department_id"
                    :options="$this->departments"
                    type="search-select-with-add"
                    :model-class="\App\Models\Department::class"
                    model-create-field="name"
                />
            </div>
            <div class="w-1/3">
                <x-form.input-field
                    name="form.crew.{{ $member['id'] }}.position"
                    label="Position"
                    wire-model="form.crew.{{ $member['id'] }}.position"
                    update-on="blur"
                />
            </div>
            @if(count($crew) > 1)
                <div class="mt-1.5">

                    <x-base.button type="button" variant="danger" icon="trash"
                                   wire:click.prevent="removeCrewMember('{{ $member['id'] }}')"/>
                </div>
            @else
                @if(!empty($member['person_id']) || !empty($member['department_id']) || !empty($member['position']))
                    <div class="mt-1.5">

                        <x-base.button type="button" variant="danger" icon="trash"
                                       wire:click.prevent="clearCrewMember('{{ $member['id'] }}')"/>
                    </div>
                @endif
            @endif
        </div>
    @endforeach
    <x-base.button type="button" icon="plus" class="mt-5" wire:click.prevent="addCrewMember">
        Weiteres Mitglied hinzufügen
    </x-base.button>
</div>
