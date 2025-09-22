<div class="mt-16">
    <p class="text-2xl">Auszeichnungen</p>

    @foreach($awardsData as $award)
        <div class="flex space-x-5 mt-5" wire:key="award-header-{{ $award['id'] }}">
            <div class="w-1/3">
                <x-form.select-field
                    name="form.awardsData.{{ $award['id'] }}.award_name"
                    label="Verleihung"
                    wire-model="form.awardsData.{{ $award['id'] }}.award_name"
                    :options="$this->awardOptions"
                    type="search-select-with-add"
                    :model-class="\App\Models\Award::class"
                    model-create-field="name"
                    :value="$award['award_name']"
                />
            </div>

            <div class="w-2/3">
                @foreach($award['categories'] as $category)
                    <div class="flex space-x-5"
                         wire:key="category-row-{{ $award['id'] }}-{{ $category['id'] }}">

                        <div class="w-1/2">
                            <x-form.select-field
                                name="form.awardsData.{{ $award['id'] }}.categories.{{ $category['id'] }}.category"
                                label="Kategorie"
                                wire-model="form.awardsData.{{ $award['id'] }}.categories.{{ $category['id'] }}.category"
                                :options="$this->categoryOptions"
                                type="search-select-with-add"
                                :model-class="\App\Models\Category::class"
                                model-create-field="name"
                            />
                        </div>

                        <div class="w-1/2">
                            <x-form.select-field
                                name="form.awardsData.{{ $award['id'] }}.categories.{{ $category['id'] }}.person_id"
                                label="Person"
                                wire-model="form.awardsData.{{ $award['id'] }}.categories.{{ $category['id'] }}.person_id"
                                :options="$this->people"
                                type="search-select-with-add"
                                :model-class="\App\Models\Person::class"
                                model-create-field="name"
                            />
                        </div>

                        @php
                            $isNotOnlyCategory = count($award['categories']) != 1;
                        @endphp

                        @if($isNotOnlyCategory)
                            <div class="flex items-center mt-1.5">
                                <x-base.button
                                    type="button"
                                    variant="danger"
                                    icon="trash"
                                    wire:click.prevent="removeCategory({{ $award['id'] }}, {{ $category['id'] }})"
                                />
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end mt-3 gap-5">


            @if(count($awardsData) > 1)
                <x-base.button
                    type="button"
                    variant="danger"
                    icon="trash"
                    wire:click="removeAward({{ $award['id'] }})">
                    Verleihung entfernen
                </x-base.button>
            @else
                <div></div>
            @endif

                <x-base.button
                    type="button"
                    icon="plus"
                    wire:click="addCategory({{ $award['id'] }})">
                    Auszeichnung hinzufügen
                </x-base.button>
        </div>
    @endforeach

    <div class="flex justify-start">
        <x-base.button
            type="button"
            icon="plus"
            class="mt-5"
            wire:click="addAward">
            Weitere Verleihung hinzufügen
        </x-base.button>
    </div>
</div>
