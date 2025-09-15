@props([
    'title',
    'countries',
    'nationalities',
    'languages',
    'departments',
    'sortOptions',
    'sortBy',
    'viewMode',
    'people'
])

<div class="flex mt-8 space-x-10">
    <div class="w-1/5">
        <div class="flex items-center space-x-2.5 pb-5">
            <x-icons.filter/>
            <p class="text-xl font-semibold">Filter</p>
        </div>
        @livewire('people.person-filter', [
                'countries' => $countries,
                'nationalities' => $nationalities,
                'languages' => $languages,
                'departments' => $departments
            ])
    </div>
    <div class="w-4/5">
        <x-page-header
            :title="$title"
            :sortOptions="$sortOptions"
            :sortBy="$sortBy"
            :viewMode="$viewMode"
        />
        <div class="my-10">
            {{ $slot }}
        </div>
        <div class="flex justify-between items-center">
            <x-pagination :paginator="$people" />
            <div class="flex items-center space-x-3 mt-8">
                <p>Elemente pro Seite</p>
                <livewire:base.selection
                    wire:model.live="perPage"
                    class="w-20"
                    :options="[
                        ['value' => 6, 'text' => 6],
                        ['value' => 7, 'text' => 7],
                        ['value' => 10, 'text' => 10],
                        ['value' => 20, 'text' => 20],
                        ['value' => 50, 'text' => 50],
                        ['value' => 100, 'text' => 100],
                    ]"
                    select-first="true"
                />
            </div>
        </div>
    </div>
</div>
