<div class="mt-16">
    <p class="text-2xl">Rollen in Filmen</p>
    @foreach($cast as $actor)
        <div class="flex space-x-5 mt-5 items-center" wire:key="actor-{{ $actor['id'] }}">
            <div class="w-1/2">
                <x-form.select-field
                    name="form.cast.{{ $actor['id'] }}.movie_id"
                    label="Film"
                    wire-model="form.cast.{{ $actor['id'] }}.movie_id"
                    :options="$this->movies"
                    type="search-select-with-add"
                    :model-class="\App\Models\Movie::class"
                    model-create-field="title"
                    :value="$actor['movie_id']"
                />
            </div>
            <div class="w-1/2">
                <x-form.input-field
                    name="form.cast.{{ $actor['id'] }}.role_name"
                    label="Rolle"
                    wire-model="form.cast.{{ $actor['id'] }}.role_name"
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
        Weitere Rolle hinzufügen
    </x-base.button>
</div>
