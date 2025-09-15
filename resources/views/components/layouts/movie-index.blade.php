@props([
    'title',
    'countries',
    'ageRatings',
    'genres',
    'sortOptions',
    'sortBy',
    'viewMode',
    'movies'
])

<div class="flex mt-8 space-x-10">
    <div class="w-1/5">
        <div class="flex items-center space-x-2.5 pb-5">
            <x-icons.filter/>
            <p class="text-xl font-semibold">Filter</p>
        </div>
        @livewire('movies.movie-filter', [
                'countries' => $countries,
                'ageRatings' => $ageRatings,
                'genres' => $genres
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
        <x-pagination :paginator="$movies" />
    </div>
</div>
