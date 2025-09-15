@props(['departments'])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-8">
    @foreach($departments as $department)
        <div class="space-y-1.5">
            <h3 class="text-white text-lg">
                {{ $department->name }}
            </h3>

            <div class="space-y-3">
                @foreach($department->movies as $movie)
                    <div class="space-y-1">
                        <a href="{{route('movies.details', $movie)}}" class=" text-indigo-300 font-light hover:text-white
                           block transition-colors duration-200">
                            {{ $movie->title }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

