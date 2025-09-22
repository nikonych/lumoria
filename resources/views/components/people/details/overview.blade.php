@props(['person'])
<div>
    <div class="flex justify-between mb-8">
        <p class="text-indigo-400 text-sm">
            <a href="/people" class="font-light cursor-pointer">Personen</a> /
            <a href="/people/all" class="font-light cursor-pointer">Alle anzeigen</a> /
            <a href="{{route('people.details', $person)}}"
               class="font-semibold cursor-pointer">{{$person->name}}</a>
        </p>
        @auth
            @if(auth()->user()->id === $person->created_by)
                <div class="flex space-x-2.5">
                    <x-base.button variant="secondary" icon="pen" href="{{ route('people.edit', $person) }}">
                        Bearbeiten
                    </x-base.button>
                    @livewire('people.delete-person-button', ['person' => $person])
                </div>
            @endif
        @endauth
    </div>
    <div class="flex space-x-12">
        <div class="flex-shrink-0">
            <img src="{{ $person->profile_url }}" alt="{{ $person->name }}" class="w-xs rounded-xs">
        </div>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <h1 class="text-5xl font-bold">{{ $person->name }}</h1>
                @livewire('people.favorite-button', ['person' => $person])
            </div>
            <div class="flex items-center space-x-2.5 mt-3.5">
                @foreach($person->departments as $department)
                    <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                    {{ $department->name }}
                </span>
                @endforeach
            </div>
            <div class="mt-5">
                <dl class="grid grid-cols-2 max-w-2/3 font-light gap-y-1.5">
                    <dt class="">Geboren:</dt>
                    <dd class="text-slate-400">{{$person->birth_date}}</dd>
                    @if($person->nationality)
                        <dt class="">Nationalität:</dt>
                        <dd class="text-slate-400">{{$person->nationality->name}}</dd>
                    @endif
                    <dt class="">Wohnort:</dt>
                    <dd class="text-slate-400">{{$person->birth_place}}</dd>

                    <dt class="">Sprachen:</dt>
                    <dd class="text-slate-400">{{$person->languages->pluck('name')->implode(', ') }}</dd>
                </dl>
            </div>
            <div class="mt-5 font-light">
                <p class="font-extralight">{{$person->description}}</p>
            </div>
        </div>
    </div>
</div>
