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
                <section id="overview" class="mb-16">
                    <x-movies.details.overview :movie="$movie"/>
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
                        <x-movies.details.crew-list :crew="$movie->crew"/>
                    @endif
                </x-base.section>
                <x-base.section title="Auszeichnungen" id="awards">
                    <x-movies.details.awards-list :awards="$awards"/>
                </x-base.section>
                <x-base.section title="Bewertungen" id="reviews">
                    <x-movies.details.reviews :movie="$movie" :rating-percentages="$ratingPercentages"/>
                </x-base.section>
                <x-base.section title="Trailer" id="trailer">
                    <x-movies.details.trailer :trailer_url="$movie->trailer_url"/>
                </x-base.section>

                <x-base.section title="Ähnliche Titel" id="similar">
                    @livewire('movies.movie-list', [
                        'type' => 'similar',
                        'movie' => $movie,
                        'title' => null
                    ])
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
