<x-layouts.person-index
    :title="$title"
    :countries="$countries"
    :nationalities="$nationalities"
    :languages="$languages"
    :departments="$departments"
    :sortOptions="$sortOptions"
    :sortBy="$sortBy"
    :viewMode="$viewMode"
    :people="$people"
>
    @php
        $cardComponent = $viewMode === 'grid' ? 'people.card' : 'people.card-list';
    @endphp

    <div @class([
        'space-y-4' => $viewMode === 'list',
        'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8' => $viewMode === 'grid',
    ])>
        @foreach($people as $person)
            <x-dynamic-component :component="$cardComponent" :person="$person" />
        @endforeach
    </div>
</x-layouts.person-index>
