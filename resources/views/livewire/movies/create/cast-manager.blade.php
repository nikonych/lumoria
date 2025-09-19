<div class="mt-16">
    <p class="text-2xl">Besetzung</p>
    @foreach($cast as $actor)
        <div class="flex space-x-5 mt-5 items-center" wire:key="actor-{{ $actor['id'] }}">
            <div class="w-1/2">
                <x-form.select-field
                    name="form.cast.{{ $actor['id'] }}.person_id"
                    label="Schauspieler:in"
                    wire-model="form.cast.{{ $actor['id'] }}.person_id"
                    :options="$this->people"
                    type="search-select-with-add"
                    :model-class="\App\Models\Person::class"
                    model-create-field="name"
                />
            </div>
            <div class="w-1/2">
                <x-form.input-field
                    name="form.cast.{{ $actor['id'] }}.role_name"
                    label="Rolle"
                    wire-model="form.cast.{{ $actor['id'] }}.role_name"
                    update-on="blur"
                />
            </div>
            @if(count($cast) > 1)
                <div class="mt-1.5">

                <x-base.button type="button" variant="danger" icon="trash"
                               wire:click.prevent="removeActor({{$actor['id'] }})"/>
                </div>
            @else
                @if(!empty($actor['person_id']) || !empty($actor['role_name']))
                    <div class="mt-1.5">

                    <x-base.button type="button" variant="danger" icon="trash"
                                   wire:click.prevent="clearActor({{ $actor['id'] }})"/>
                    </div>
                @endif
            @endif
        </div>
    @endforeach
    <x-base.button type="button" icon="plus" class="mt-5" wire:click.prevent="addActor">
        Weitere Schauspieler:innen hinzufügen
    </x-base.button>
</div>
