<form wire:submit="save">
    <div class="mb-16">
        <div>
            <div class="flex space-x-12">
                <div class="w-1/7 max-w-sm">
                    <p class="font-medium text-sm mb-1.5">Titelbild</p>

                    <div
                        class="aspect-[3/5] bg-input-dark flex hover:bg-slate-700 items-center transition-colors duration-200 justify-center relative rounded-sm">
                        @if ($form->poster)
                            <img src="{{ $form->poster->temporaryUrl() }}" class="object-cover h-full w-full rounded-sm"
                                 alt="poster">
                        @else
                            <div class="text-slate-500">
                                <x-icons.image/>
                            </div>
                        @endif

                    </div>

                    <input type="file" id="imageUpload" class="hidden" wire:model="form.poster">
                    @error('form.poster') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror


                    <div class="flex mt-3.5 space-x-2.5 items-center justify-between">
                        <x-base.button type="button" variant="secondary"
                                       onclick="document.getElementById('imageUpload').click()"
                                       class="w-3/5 text-xs py-2.5 px-4 rounded-md">
                            Datei hochladen
                        </x-base.button>
                        <p class="text-xs w-2/5 text-slate-500 text-center">.jpg, .png</p>
                    </div>
                </div>
                <div class="w-6/7 flex flex-col">
                    <div class="flex space-x-5">
                        <div class="w-1/2 space-y-5">
                            <x-base.input>
                                <x-slot name="label">
                                    Titel
                                </x-slot>
                            </x-base.input>
                            @error('form.title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <x-base.input>
                                <x-slot name="label">
                                    Produktionsland
                                </x-slot>
                            </x-base.input>
                            <div class="flex space-x-5">
                                <div class="w-1/2">
                                    <x-base.input>
                                        <x-slot name="label">
                                            Originalsprache
                                        </x-slot>
                                    </x-base.input>
                                </div>
                                <div class="w-1/2">
                                    <x-base.input type="number" wire:model.blur="form.release_year">
                                        <x-slot name="label">Erscheinungsjahr</x-slot>
                                    </x-base.input>
                                    @error('form.release_year') <span
                                        class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-1/2 space-y-5">
                            <x-base.input wire:model.blur="form.original_title">
                                <x-slot name="label">Originaltitel</x-slot>
                            </x-base.input>
                            @error('form.original_title') <span
                                class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <x-base.input wire:model.blur="form.trailer_url" :has-icon="true">
                                <x-slot name="label">Link zum Trailer</x-slot>
                                <x-slot name="icon">
                                    <x-icons.envelope/>
                                </x-slot>
                            </x-base.input>
                            @error('form.trailer_url') <span
                                class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <div class="flex space-x-5">
                                <div class="w-1/2">
                                    <x-base.input type="number" wire:model.blur="form.duration_minutes">
                                        <x-slot name="label">Dauer in Minuten</x-slot>
                                    </x-base.input>
                                    @error('form.duration_minutes') <span
                                        class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-1/2">
                                    <x-base.input wire:model.blur="form.age_rating">
                                        <x-slot name="label">Altersfreigabe</x-slot>
                                    </x-base.input>
                                    @error('form.age_rating') <span
                                        class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 grow">
                        <x-base.textarea wire:model.blur="form.description">
                            <x-slot name="label">Beschreibung</x-slot>
                        </x-base.textarea>
                        @error('form.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div>
                <p class="mt-5 text-sm mb-1.5">Genre</p>
                <div class="grid grid-cols-8">
                    @foreach($genres as $genre)
                        <div class="flex items-center">
                            <x-base.checkbox wire:model="form.selectedGenres" value="{{ $genre->id }}"
                                             label="{{ $genre->name }}" id="genre-{{ $loop->index }}"/>
                        </div>
                    @endforeach
                </div>
                @error('form.selectedGenres') <span
                    class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
            </div>
            <div class="mt-16">
                <p class="text-2xl mb-5">Fotos hinzufügen</p>
                <div
                    class=" bg-input-dark flex hover:bg-slate-700 items-center transition-colors duration-200 justify-center relative rounded-sm">
                    <div class="mt-10 flex flex-col justify-center items-center space-y-2.5">
                        <x-icons.inbox-in/>
                        <p class="text-slate-400 text-sm font-light">Dateien hierher ziehen</p>
                        <p class="text-slate-400 text-sm font-light">oder</p>
                        <x-base.button variant="secondary"
                                       class=" bg-bg-secondary mb-10 hover:bg-slate-700 text-xs py-2.5 px-4 rounded-md transition-colors duration-200"
                        >
                            Dateien durchsuchen
                        </x-base.button>
                    </div>

                    <input type="file" id="imageUpload" accept="image/*,.jpg,.png,.pdf" class="hidden">
                </div>
            </div>
            <div class="mt-16">
                <p class="text-2xl">Besetzung</p>
                @foreach($cast as $actor)
                    <div class="flex space-x-5 mt-5 items-end" wire:key="actor-{{ $actor['id'] }}">
                        <div class="w-1/2">
                            <label class="block mb-1.5 text-sm text-slate-50">Schauspieler:in</label>
                            <livewire:base.search-select
                                wire:model.blur="cast.{{ $actor['id'] }}.person_id"
                                :options="$people->map(fn($p) => ['value' => $p->id, 'text' => $p->name])->toArray()"
                                class="w-full"/>
                        </div>
                        <div class="w-1/2">
                            <x-base.input wire:model.blur="cast.{{ $actor['id'] }}.role_name">
                                <x-slot name="label">Rolle</x-slot>
                            </x-base.input>
                        </div>
                        @if(count($cast) > 1)
                            <x-base.button type="button" variant="danger" icon="trash" wire:click.prevent="removeActor('{{ $actor['id'] }}')"/>
                        @else
                            @if(!empty($actor['person_id']) || !empty($actor['role_name']))
                                <x-base.button type="button" variant="danger" icon="trash" wire:click.prevent="clearActor('{{ $actor['id'] }}')"/>
                            @endif
                        @endif
                    </div>
                @endforeach
                <x-base.button type="button" icon="plus" class="mt-5" wire:click.prevent="addActor">
                    Weitere Schauspieler:innen hinzufügen
                </x-base.button>
            </div>
            <div class="mt-16">
                <p class="text-2xl">Filmstab</p>
                @foreach($crew as $member)
                    <div class="flex space-x-5 mt-5 items-end" wire:key="crew-{{ $member['id'] }}">
                        <div class="w-1/3">
                            <label class="block mb-1.5 text-sm text-slate-50">Person</label>
                            <livewire:base.search-select
                                wire:model.blur="crew.{{ $member['id'] }}.person_id"
                                :options="$people->map(fn($p) => ['value' => $p->id, 'text' => $p->name])->toArray()"
                                class="w-full"/>
                        </div>
                        <div class="w-1/3">
                            <label class="block mb-1.5 text-sm text-slate-50">Abteilung</label>
                            <livewire:base.selection
                                wire:model.blur="crew.{{ $member['id'] }}.department_id"
                                :options="$departments->map(fn($d) => ['value' => $d->id, 'text' => $d->name])->toArray()"
                                class="w-full"/>
                        </div>
                        <div class="w-1/3">
                            <x-base.input wire:model.blur="crew.{{ $member['id'] }}.position">
                                <x-slot name="label">Position</x-slot>
                            </x-base.input>
                        </div>
                        @if(count($crew) > 1)
                            <x-base.button type="button" variant="danger" icon="trash" wire:click.prevent="removeCrewMember('{{ $member['id'] }}')"/>
                        @else
                            @if(!empty($member['person_id']) || !empty($member['department_id']) || !empty($member['position']))
                                <x-base.button type="button" variant="danger" icon="trash" wire:click.prevent="clearCrewMember('{{ $member['id'] }}')"/>
                            @endif
                        @endif
                    </div>
                @endforeach
                <x-base.button type="button" icon="plus" class="mt-5" wire:click.prevent="addCrewMember">
                    Weiteres Mitglied hinzufügen
                </x-base.button>
            </div>
            <div class="mt-16">
                <p class="text-2xl">Auszeichnungen</p>
                <div class="flex space-x-5 mt-5">
                    <div class="w-1/3">
                        <label class="block mb-1.5 text-sm text-slate-50" for="Verleihung">Verleihung</label>
                        <livewire:base.selection class="w-full"/>
                    </div>
                    <div class="w-1/3">
                        <label class="block mb-1.5 text-sm text-slate-50" for="Kategorie">Kategorie</label>
                        <livewire:base.selection class="w-full"/>
                    </div>
                    <div class="w-1/3">
                        <label class="block mb-1.5 text-sm text-slate-50" for="Person(en)">Person(en)</label>
                        <livewire:base.selection class="w-full"/>
                    </div>
                </div>
                <div class="flex justify-end">
                    <x-base.button icon="plus" class="mt-5">
                        Auszeichnung hinzufügen
                    </x-base.button>
                </div>
                <x-base.button icon="plus" class="mt-5">
                    Weitere Verleihung hinzufügen
                </x-base.button>
            </div>
            <div class="flex justify-end mt-16 space-x-5">
                <x-base.button type="button" variant="secondary">
                    Abbrechen
                </x-base.button>
                <x-base.button type="submit">
                    Film hinzufügen
                </x-base.button>
            </div>
        </div>
    </div>
</form>
