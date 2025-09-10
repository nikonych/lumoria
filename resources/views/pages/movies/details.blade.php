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
                            <img src="{{ $movie->poster_image }}" alt="{{ $movie->title }}" class="w-80 rounded-lg">
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
                                <div class="flex items-center gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($movie->rating))
                                            <svg class="w-6 h-6 text-indigo-600 fill-current" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @elseif($i == ceil($movie->rating) && $movie->rating - floor($movie->rating) >= 0.5)
                                            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half-{{ $movie->id }}-{{ $i }}">
                                                        <stop offset="50%" stop-color="currentColor"/>
                                                        <stop offset="50%" stop-color="transparent"/>
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-{{ $movie->id }}-{{ $i }})"
                                                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                <path stroke="currentColor" stroke-width="1" fill="none"
                                                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>

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
                                        <svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4766 1.75C12.3203 1.75 12.9766 2.42969 12.9766 3.25V9.25C12.9766 10.0938 12.2969 10.75 11.4766 10.75H2.47656C1.63281 10.75 0.976562 10.0938 0.976562 9.25V1.75C0.976562 0.929688 1.63281 0.25 2.47656 0.25H5.24219C5.64062 0.25 6.01562 0.414062 6.29688 0.695312L7.44531 1.75H11.4766ZM11.8516 9.25V3.25C11.8516 3.0625 11.6641 2.875 11.4766 2.875H6.97656L5.47656 1.49219C5.40625 1.42188 5.3125 1.375 5.21875 1.375H2.47656C2.26562 1.375 2.10156 1.5625 2.10156 1.75V9.25C2.10156 9.46094 2.26562 9.625 2.47656 9.625H11.4766C11.6641 9.625 11.8516 9.46094 11.8516 9.25Z" fill="white"/>
                                        </svg>
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>
                </section>

                <!-- Gallery Section -->
                <section id="gallery" class="mb-16">
                    <h2 class="text-2xl font-bold mb-6">Galerie</h2>
                    <!-- Gallery content here -->
                </section>

                <!-- Cast Section -->
                <section id="cast" class="mb-16">
                    <h2 class="text-2xl font-bold mb-6">Besetzung</h2>
                    <!-- Cast content here -->
                </section>

                <section id="crew" class="mb-16">
                    <h2 class="text-2xl font-bold mb-6">Filmstab</h2>
                    <div>
                        <p><strong class="text-white">Regisseur:</strong> John Doe</p>
                        <p><strong class="text-white">Drehbuch:</strong> Jane Smith</p>
                    </div>
                </section>

                <section id="awards" class="mb-16">
                    <h2 class="text-2xl font-bold mb-6">Auszeichnungen</h2>
                    <ul>
                        <li class="mb-2">🏆 Bester Film - Academy Awards</li>
                        <li class="mb-2"> номинация - Golden Globes</li>
                    </ul>
                </section>


                <!-- Reviews Section -->
                <section id="reviews" class="mb-16">
                    <h2 class="text-2xl font-bold mb-6">Bewertungen</h2>
                    <!-- Reviews content here -->
                </section>

                <!-- Trailer Section -->
                <section id="trailer" class="mb-16">
                    <h2 class="text-2xl font-bold mb-6">Trailer</h2>
                    <!-- Trailer content here -->
                </section>

                <!-- Similar Movies Section -->
                <section id="similar" class="mb-16">
                    <h2 class="text-2xl font-bold mb-6">Ähnliche Titel</h2>
                    <!-- Similar movies content here -->
                </section>
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
