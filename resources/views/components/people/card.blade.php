@props([
    'person' => null
])

<div class="flex flex-col overflow-hidden group">

    <div class="relative w-full overflow-hidden">
        <a class="cursor-pointer" href="{{route('people.details', $person)}}">
            <img src="{{$person->profile_url}}" alt="{{$person->name}}"
                 class="w-full h-full object-cover rounded-sm">
        </a>
    </div>

    <div class="flex flex-col flex-grow py-3">
        <div class="flex-grow">
            <a class="cursor-pointer" href="{{route('people.details', $person)}}">
                <p class="text-indigo-300 line-clamp-1 cursor-pointer">{{$person->name}}</p>
            </a>
        </div>
        @if($person->departments->isNotEmpty())
            <p class="text-sm font-light text-slate-50 line-clamp-1 mt-auto pt-1">
                <span>{{$person->departments->first()->name}}</span>
            </p>
        @endif
    </div>
</div>
