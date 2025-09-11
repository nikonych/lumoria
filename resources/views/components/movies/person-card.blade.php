@props([
    'person' => null
])

<div class="flex flex-col w-40 overflow-hidden group">

    <div class="relative w-full h-60 overflow-hidden">
        <a class="cursor-pointer" href="/">
        <img src="{{$person->profile_image}}" alt="{{$person->name}}"
             class="w-full h-full object-cover rounded-sm">
        </a>
    </div>

    <div class="flex flex-col flex-grow py-3">
        <div class="flex-grow">
            <a class="cursor-pointer" href="/">
            <p class="text-indigo-300 line-clamp-2 h-12 cursor-pointer">{{$person->name}}</p>
            </a>
        </div>

            <p class="text-sm font-light text-slate-50 line-clamp-1 mt-auto pt-1">
                    <span>{{$person->pivot->name}}</span>
            </p>
    </div>
</div>
