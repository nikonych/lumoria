@props(['awards'])

@if ($awards->isNotEmpty())
    @foreach($awards as $award)
        <div class="pt-5">
            <h3 class="text-white text-lg font-semibold mb-2.5">
                {{ $award->name }}
            </h3>

            <div class="grid grid-cols-2 gap-x-20 gap-y-2">

                @foreach($award->people as $person)
                    <div class="grid grid-cols-2 gap-x-16 items-center">
                        <a href="#" class="text-indigo-300 font-light hover:text-white truncate pr-4">
                            {{ $person->name }}
                        </a>
                        <p class="text-sm font-light">
                            {{ $award->category }}
                        </p>
                    </div>
                @endforeach

            </div>
        </div>
    @endforeach
@endif
