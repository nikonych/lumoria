<div class="flex space-x-12">
    <div class="w-1/7 max-w-sm">
        <x-form.image-upload
            name="poster"
            label="Titelbild"
            wire-model="form.profile_image"
            :current-image="$form->profile_image"
            wrapper-class=""
        />
    </div>

    <div class="flex-1 flex flex-col">
        <x-form.input-field
            name="form.name"
            label="Name"
            wire-model="form.name"
            update-on="blur"
        />
        <div class="flex space-x-5">
            <div class="w-1/2">
                <div class="flex space-x-5">
                    <div class="w-1/2">
                        <x-form.input-field
                            name="form.birth_date"
                            label="Geburtstag"
                            wire-model="form.birth_date"
                            update-on="blur"
                            type="date"
                        />
                    </div>
                    <div class="w-1/2">
                        <x-form.input-field
                            name="form.death_date"
                            label="Todestag (falls zutreffend)"
                            wire-model="form.death_date"
                            update-on="blur"
                            type="date"
                        />
                    </div>
                </div>


                <x-form.select-field
                    name="form.nationality_id"
                    label="Nationalität"
                    wire-model="form.nationality_id"
                    :options="$this->countries"
                    :value="$form->nationality_id"
                    type="search-select-with-add"
                    :model-class="\App\Models\Country::class"
                    model-create-field="name"
                />

            </div>

            <div class="w-1/2">
                <x-form.input-field
                    name="form.birth_place"
                    label="Wohnort"
                    wire-model="form.birth_place"
                />

                <x-form.select-field
                    name="form.selectedLanguage_id"
                    label="Gesprochene Sprachen"
                    wire-model="form.selectedLanguage_id"
                    :options="$this->countries"
                    :value="$form->selectedLanguage_id"
                    type="search-select-with-add"
                    :model-class="\App\Models\Country::class"
                    model-create-field="name"
                />
           </div>
        </div>

        <x-form.textarea-field
            name="form.description"
            label="Kurzbeschreibung"
            wire-model="form.description"
        />

        @include('livewire.people.create.department-manager')
    </div>
</div>
