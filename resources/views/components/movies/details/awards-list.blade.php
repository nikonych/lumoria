@props(['awards'])

@if ($awards->isNotEmpty())
    @foreach($awards as $awardName => $winners)
        <div class="pt-5">
            <h3 class="text-white text-lg font-semibold mb-2.5">
                {{ $awardName }}
            </h3>

            <div class="grid grid-cols-2 gap-x-20 gap-y-2">

                @foreach($winners as $winner)
                    @if ($winner->person)
                        <div class="grid grid-cols-2 gap-x-16 items-center">
                            <a href="{{route('people.details', $winner->person)}}" class="text-indigo-300 font-light hover:text-white truncate pr-4">
                                {{ $winner->person->name }}
                            </a>
                            <p class="text-sm font-light">
                                {{ $winner->award->category }}
                            </p>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    @endforeach
@endif
