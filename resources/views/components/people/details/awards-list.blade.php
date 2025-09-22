@props(['awards'])

@if ($awards->isNotEmpty())
    @foreach($awards as $awardName => $winners)
        <div class="pt-5">
            <h3 class="text-white text-lg font-semibold mb-2.5">
                {{ $awardName }}
            </h3>

            <div class="grid grid-cols-2 gap-x-20 gap-y-2">
                @foreach($winners as $winner)
                    @if ($winner->movie)
                        <div class="grid grid-cols-2 gap-x-16 items-center">
                            <a href="{{route('movies.details', $winner->movie)}}" class="text-indigo-300 font-light hover:text-white truncate pr-4">
                                {{ $winner->movie->title }}
                            </a>
                            <p class="text-sm font-light">
                                {{ $winner->category->name }}
                            </p>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    @endforeach
@endif
