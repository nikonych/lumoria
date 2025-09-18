<div class="flex space-x-12">
    <div class="w-1/7 max-w-sm">
        <x-form.image-upload
            name="poster"
            label="Titelbild"
            wire-model="form.poster_image"
            :current-image="$form->poster_image"
            wrapper-class=""
        />
    </div>

    <div class="flex-1 flex flex-col">
        <div class="flex space-x-5">
            <div class="w-1/2">
                <x-form.input-field
                    name="form.title"
                    label="Titel"
                    wire-model="form.title"
                    update-on="blur"
                />

                <x-form.select-field
                    name="form.original_country_id"
                    label="Produktionsland"
                    wire-model="form.original_country_id"
                    :options="$this->countries"
                    type="search-select-with-add"
                    :model-class="\App\Models\Country::class"
                    model-create-field="name"
                />

                <div class="flex space-x-5">
                    <div class="w-1/2">
                        <x-form.select-field
                            name="form.original_language_id"
                            label="Originalsprache"
                            wire-model="form.original_language_id"
                            :options="$this->languages"
                        />
                    </div>
                    <div class="w-1/2">
                        <x-form.input-field
                            name="form.release_year"
                            label="Erscheinungsjahr"
                            wire-model="form.release_year"
                            type="number"
                        />
                    </div>
                </div>
            </div>

            <!-- Правая колонка -->
            <div class="w-1/2">
                <x-form.input-field
                    name="form.original_title"
                    label="Originaltitel"
                    wire-model="form.original_title"
                />

                <x-form.input-field
                    name="form.trailer_url"
                    label="Link zum Trailer"
                    wire-model="form.trailer_url"
                    has-icon="true"
                    icon="envelope"
                />

                <div class="flex space-x-5">
                    <div class="w-1/2">
                        <x-form.input-field
                            name="form.duration_minutes"
                            label="Dauer in Minuten"
                            wire-model="form.duration_minutes"
                            type="number"
                        />
                    </div>
                    <div class="w-1/2">
                        <x-form.select-field
                            name="form.age_rating"
                            label="Altersfreigabe"
                            wire-model="form.age_rating"
                            :options="$ageRatingOptions"
                        />
                    </div>
                </div>
            </div>
        </div>

        <x-form.textarea-field
            name="form.description"
            label="Beschreibung"
            wire-model="form.description"
        />
    </div>
</div>
