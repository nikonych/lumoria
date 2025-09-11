<x-layouts.app>
    <div class="mx-24 mt-12">
        <div class="flex mt-8 space-x-10">
            <div class="w-1/6 p-6 sticky top-0 h-screen">
                <div id="nav-menu" class="space-y-2 text-sm text-slate-400 font-light">
                    <a href="#overview" class="block text-gray-300 px-2 hover:text-white transition-colors py-0.5">Übersicht</a>
                    <a href="#gallery" class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Galerie</a>
                    <a href="#cast"
                       class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Besetzung</a>
                    <a href="#crew"
                       class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Filmstab</a>
                    <a href="#awards" class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Auszeichnungen</a>
                    <a href="#reviews" class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Bewertungen</a>
                    <a href="#trailer" class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Trailer</a>
                    <a href="#similar" class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Ähnliche
                        Titel</a>
                </div>
            </div>

            <div class="w-5/6 p-6">
                <!-- Breadcrumb -->


                <!-- Movie Overview Section -->
                <section id="overview" class="mb-16">
                    <div class="flex justify-between mb-8">
                        <p class="text-indigo-400 text-sm">
                            <a href="/movies" class="font-light cursor-pointer">Filme</a> /
                            <a href="/movies/all" class="font-light cursor-pointer">Alle anzeigen</a> /
                            <a href="{{route('movies.details', $movie)}}"
                               class="font-semibold cursor-pointer">{{$movie->title}}</a>
                        </p>
                        <div class="flex space-x-2.5">
                            <button class="bg-bg-secondary text-white px-4 py-1.5 rounded-sm">
                                <div class="flex items-center space-x-2.5 text-sm">
                                    <p>Bearbeiten</p>
                                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.35938 8.09375L9.48438 0.96875C10.0703 0.382812 11.0312 0.382812 11.6172 0.96875L12.5312 1.88281C12.6016 1.95312 12.6719 2.04688 12.7188 2.11719C13.1172 2.70312 13.0469 3.5 12.5312 4.01562L5.40625 11.1406C5.38281 11.1641 5.33594 11.1875 5.3125 11.2344C5.07812 11.4219 4.82031 11.5625 4.53906 11.6562L1.70312 12.4766C1.51562 12.5469 1.30469 12.5 1.16406 12.3359C1 12.1953 0.953125 11.9844 1 11.7969L1.84375 8.96094C1.9375 8.63281 2.125 8.32812 2.35938 8.09375ZM2.92188 9.28906L2.38281 11.1172L4.21094 10.5781C4.35156 10.5312 4.49219 10.4609 4.60938 10.3438L9.97656 4.97656L8.5 3.52344L3.15625 8.89062C3.13281 8.89062 3.13281 8.91406 3.10938 8.9375C3.01562 9.03125 2.96875 9.14844 2.92188 9.28906Z"
                                            fill="#F8FAFC"/>
                                    </svg>
                                </div>

                            </button>
                            <button class="bg-rot text-white px-4 py-1.5 rounded-sm">

                                <div class="flex items-center space-x-2.5 text-sm">
                                    <p>Löschen</p>
                                    <svg width="11" height="13" viewBox="0 0 11 13" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.4375 2.375C10.7422 2.375 11 2.63281 11 2.9375C11 3.26562 10.7422 3.5 10.4375 3.5H10.1562L9.59375 11.1172C9.52344 11.9141 8.89062 12.5 8.09375 12.5H3.38281C2.58594 12.5 1.95312 11.9141 1.88281 11.1172L1.32031 3.5H1.0625C0.734375 3.5 0.5 3.26562 0.5 2.9375C0.5 2.63281 0.734375 2.375 1.0625 2.375H2.67969L3.54688 1.08594C3.78125 0.734375 4.20312 0.5 4.64844 0.5H6.82812C7.27344 0.5 7.69531 0.734375 7.92969 1.08594L8.79688 2.375H10.4375ZM4.64844 1.625C4.57812 1.625 4.50781 1.67188 4.48438 1.71875L4.03906 2.375H7.4375L6.99219 1.71875C6.96875 1.67188 6.89844 1.625 6.82812 1.625H4.64844ZM9.03125 3.5H2.44531L3.00781 11.0469C3.03125 11.2344 3.19531 11.375 3.38281 11.375H8.09375C8.28125 11.375 8.44531 11.2344 8.46875 11.0469L9.03125 3.5Z"
                                            fill="white"/>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="flex space-x-12">
                        <!-- Movie poster and info here -->
                        <div class="flex-shrink-0">
                            <img src="{{ $movie->poster_image }}" alt="{{ $movie->title }}" class="w-xs rounded-xs">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <h1 class="text-5xl font-bold">{{ $movie->title }}</h1>
                                <button
                                    class="group/btn rounded-full transition-all duration-300 text-gray-400 }}"
                                    data-movie-id="{{ $movie->id }}"
                                    disabled
                                >
                                    <svg class="w-12 h-12 text-gray-700"
                                         stroke="currentColor"
                                         fill="none"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center space-x-2.5 mt-3.5">
                                <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                                    {{ $movie->release_year }}
                                </span>
                                <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                                    {{ $movie->duration_minutes }} Min.
                                </span>
                                <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                                    FSK {{ $movie->age_rating }}
                                </span>
                                @if($movie->genres->isNotEmpty())
                                    <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                                        {{ $movie->genres->pluck('name')->implode(', ') }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 mt-3.5">
                                <x-base.stars :rating="$movie->rating" :movie_id="$movie->id" spacing="space-x-1.5"
                                              size="5"/>

                                <span class="font-light text-sm">
                                    {{ number_format($movie->rating, 1) }} von {{ 5 }}
                                </span>

                                <span class="text-slate-400 text-sm font-light">
                                    ({{ number_format($movie->reviews_count) }} Bewertungen)
                                </span>
                            </div>
                            <div class="mt-5">
                                <dl class="grid grid-cols-2 max-w-2/3 font-light gap-y-1.5">
                                    <dt class="">Originaltitel:</dt>
                                    <dd class="text-slate-400">{{$movie->original_title}}</dd>

                                    <dt class="">Originalsprache:</dt>
                                    <dd class="text-slate-400">{{$movie->language->name}}</dd>

                                    <dt class="">Produktionsland:</dt>
                                    <dd class="text-slate-400">{{$movie->country->name}}</dd>
                                </dl>
                            </div>
                            <div class="mt-5 font-light">
                                <p>{{$movie->description}}</p>
                            </div>
                            <div class="flex space-x-3.5 mt-5">
                                <button class="bg-indigo-700 text-white px-4 py-1.5 rounded-sm">
                                    <div class="flex items-center space-x-2.5 text-sm">
                                        <p>Watchlist</p>
                                        <svg class="w-4 h-4"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>

                                </button>
                                <button class="bg-indigo-700 text-white px-4 py-1.5 rounded-sm">

                                    <div class="flex items-center space-x-2.5 text-sm">
                                        <p>Sammlung</p>
                                        <svg width="13" height="11" viewBox="0 0 13 11" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4766 1.75C12.3203 1.75 12.9766 2.42969 12.9766 3.25V9.25C12.9766 10.0938 12.2969 10.75 11.4766 10.75H2.47656C1.63281 10.75 0.976562 10.0938 0.976562 9.25V1.75C0.976562 0.929688 1.63281 0.25 2.47656 0.25H5.24219C5.64062 0.25 6.01562 0.414062 6.29688 0.695312L7.44531 1.75H11.4766ZM11.8516 9.25V3.25C11.8516 3.0625 11.6641 2.875 11.4766 2.875H6.97656L5.47656 1.49219C5.40625 1.42188 5.3125 1.375 5.21875 1.375H2.47656C2.26562 1.375 2.10156 1.5625 2.10156 1.75V9.25C2.10156 9.46094 2.26562 9.625 2.47656 9.625H11.4766C11.6641 9.625 11.8516 9.46094 11.8516 9.25Z"
                                                fill="white"/>
                                        </svg>
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>
                </section>

                <x-base.section title="Galerie" id="gallery">
                    @if($movie->photos->isNotEmpty())
                        <x-carousel-pagination :items="$movie->photos" :per-page="4">

                            <div x-ref="container"
                                 class="flex scrollbar-hide overflow-x-auto scroll-smooth snap-x snap-mandatory space-x-3">
                                @foreach($movie->photos as $photo)
                                    <div class="snap-start flex-shrink-0 w-full sm:w-1/2 lg:w-1/4">
                                        <img src="{{$photo->file_path}}" alt="Galeriebild"
                                             class="w-full rounded-sm aspect-5/3 object-cover">
                                    </div>
                                @endforeach
                            </div>

                        </x-carousel-pagination>
                    @endif
                </x-base.section>
                <x-base.section title="Besetzung" id="cast">
                    @if($movie->actors->isNotEmpty())
                        <x-carousel-pagination :items="$movie->actors" :per-page="5">

                            <div x-ref="container"
                                 class="flex scrollbar-hide overflow-x-auto scroll-smooth snap-x snap-mandatory space-x-5">
                                @foreach($movie->actors as $actor)
                                    <div class="flex-shrink-0 w-full sm:w-1/3 lg:w-1/6">
                                        <x-movies.person-card :person="$actor"/>
                                    </div>
                                @endforeach
                            </div>

                        </x-carousel-pagination>
                    @endif
                </x-base.section>
                <x-base.section title="Filmstab" id="crew">
                    @if($movie->crew->isNotEmpty())
                        <x-movies.crew-list :crew="$movie->crew"/>
                    @endif
                </x-base.section>
                <x-base.section title="Auszeichnungen" id="awards">
                    <x-movies.awards-list :awards="$movie->awards"/>
                </x-base.section>
                <x-base.section title="Bewertungen" id="reviews">
                    <div>
                        <div class="flex space-x-5">
                            <div class="flex flex-col items-center w-1/3 bg-bg-card p-5 rounded-sm">
                                <div class="flex items-center gap-0.5">
                                    <x-base.stars :rating="$movie->rating" :movie_id="$movie->id"
                                                  spacing="space-x-1.5"/>
                                </div>
                                <span class="font-semibold text-2xl mt-5">
                                    {{ number_format($movie->rating, 1) }} von {{ 5 }}
                                </span>

                                <span class="text-indigo-200 text-sm font-light">
                                    {{ number_format($movie->reviews_count) }} Bewertungen
                                </span>
                                <div class="rating-histogram space-y-2 mt-5 w-full">
                                    @if($movie->hasReviews())
                                        @for($rating = 5; $rating >= 1; $rating--)
                                            @php
                                                $percentage = $ratingPercentages[$rating] ?? 0;
                                                $count = $movie->reviews()->where('rating', $rating)->count();
                                            @endphp
                                            <div class="flex items-center space-x-3">
                                                <span class=" font-light">{{ $rating }}</span>
                                                <div class="flex-1 bg-indigo-950 rounded-full h-3 relative">
                                                    <div
                                                        class="bg-indigo-700 h-3 rounded-full transition-all duration-300"
                                                        style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="text-sm font-light min-w-[40px] text-right">{{ $percentage }}%</span>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col w-2/3 bg-bg-card p-5 rounded-sm">
                                <div class="flex justify-between">
                                    <p class="text-2xl font-semibold">Deine Bewertung:</p>
                                    <x-base.stars :rating="0" :movie_id="$movie->id"
                                                  spacing="space-x-3" size="8"/>

                                </div>
                                <div class="mt-4">
                                    <x-base.input>
                                        <x-slot name="label">
                                            Titel (optional)
                                        </x-slot>
                                    </x-base.input>
                                </div>
                                <div class="mt-4 flex flex-col flex-1 overflow-hidden min-h-0 rounded-sm">
                                    <x-base.input type="textarea">
                                        <x-slot name="label" class="">
                                            Bewertung (optional)
                                        </x-slot>
                                    </x-base.input>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <button class="bg-indigo-700 text-sm py-2 px-4 rounded-sm">Bewertung abschicken
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <livewire:movies.movie-reviews :movie="$movie" />
                        </div>
                    </div>
                </x-base.section>
                <x-base.section title="Trailer" id="trailer">
                    @if($movie->trailer_url)
                        <div class="aspect-video mx-28">
                            <iframe
                                src="{{ str_replace('watch?v=', 'embed/', $movie->trailer_url) }}"
                                title="Trailer"
                                class="w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                </x-base.section>

                <x-base.section title="Ähnliche Titel" id="similar">
                    <x-movies.awards-list :awards="$movie->awards"/>
                </x-base.section>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.scrollTo(0, 0);

            const sections = document.querySelectorAll('section[id]');

            const activeClasses = ['border-l', 'border-indigo-700', 'text-white'];

            const removeActiveClasses = () => {
                document.querySelectorAll('#nav-menu a').forEach(link => {
                    link.classList.remove(...activeClasses);
                });
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        removeActiveClasses();

                        const id = entry.target.getAttribute('id');
                        const activeLink = document.querySelector(`#nav-menu a[href="#${id}"]`);

                        if (activeLink) {
                            activeLink.classList.add(...activeClasses);
                        }
                    }
                });
            }, {
                threshold: 0.5
            });

            sections.forEach(section => {
                observer.observe(section);
            });

            const overviewLink = document.querySelector('a[href="#overview"]');

            if (overviewLink) {
                overviewLink.addEventListener('click', function (event) {
                    event.preventDefault();

                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        });
    </script>
</x-layouts.app>
