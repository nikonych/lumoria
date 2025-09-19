<x-layouts.app>
    <div class="flex mt-8 space-x-10">
        <div class="w-1/6 p-6 sticky top-0 h-screen">
            <div id="nav-menu" class="space-y-2 text-sm text-slate-400 font-light">
                <a href="#overview"
                   class="block text-gray-300 px-2 hover:text-white transition-colors py-0.5">Übersicht</a>
                @if($person->photos->isNotEmpty())
                    <a href="#gallery" class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Galerie</a>
                @endif
                @if(!empty($person->biography))
                    <a href="#biography"
                       class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Biografie</a>
                @endif
                @if($person->actedMovies->isNotEmpty())
                    <a href="#films"
                       class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Filme</a>
                @endif
                @if($person->moviesGroupedByDepartment->isNotEmpty())
                    <a href="#crew" class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Hinter
                        den
                        Kulissen</a>
                @endif
                @if($person->awardsGroupedByName->isNotEmpty())
                    <a href="#awards" class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Auszeichnungen</a>
                @endif
                @if($similarPeople->isNotEmpty())
                    <a href="#similar" class="block text-gray-300 hover:text-white transition-colors px-2 py-0.5">Ähnliche
                        Personen</a>
                @endif
            </div>

        </div>

        <div class="w-5/6 p-6">
            <section id="overview" class="mb-16">
                <x-people.details.overview :person="$person"/>
            </section>
            @if($person->photos->isNotEmpty())
                <x-base.section title="Galerie" id="gallery">
                    @if($person->photos->isNotEmpty())
                        <x-carousel-pagination :items="$person->photos" :per-page="4">

                            <div x-ref="container"
                                 class="flex scrollbar-hide overflow-x-auto scroll-smooth snap-x snap-mandatory space-x-3">
                                @foreach($person->photos as $photo)
                                    <div class="snap-start flex-shrink-0 w-full sm:w-1/2 lg:w-1/4">
                                        <img src="{{$photo->url}}" alt="Galeriebild"
                                             class="w-full rounded-sm aspect-5/3 object-cover">
                                    </div>
                                @endforeach
                            </div>

                        </x-carousel-pagination>
                    @endif
                </x-base.section>
            @endif
            @if(!empty($person->biography))
                <x-base.section title="Biografie" id="biography">
                    <p class="text-sm">{{$person->biography}}</p>
                </x-base.section>
            @endif
            @if($person->actedMovies->isNotEmpty())
                <x-base.section title="Als Schauspieler" id="films">
                    @if($person->actedMovies->isNotEmpty())
                        <x-carousel-pagination :items="$person->actedMovies" :per-page="5">

                            <div x-ref="container"
                                 class="flex scrollbar-hide overflow-x-auto scroll-smooth snap-x snap-mandatory space-x-5">
                                @foreach($person->actedMovies as $movie)
                                    <div class="flex-shrink-0">
                                        <x-movies.card :movie="$movie"/>
                                    </div>
                                @endforeach
                            </div>

                        </x-carousel-pagination>
                    @endif
                </x-base.section>
            @endif
            @if($person->moviesGroupedByDepartment->isNotEmpty())
                <x-base.section title="Hinter den Kulissen" id="crew">
                    <x-people.details.crew-list :departments="$person->moviesGroupedByDepartment"/>
                </x-base.section>
            @endif
            @if($person->awardsGroupedByName->isNotEmpty())
                <x-base.section title="Auszeichnungen" id="awards">
                    <x-people.details.awards-list :awards="$person->awardsGroupedByName"/>
                </x-base.section>
            @endif
            @if($similarPeople->isNotEmpty())
                <x-base.section title="Ähnliche Personen" id="similar">
                    <x-carousel-pagination :items="$similarPeople" :per-page="5">

                        <div x-ref="container"
                             class="flex scrollbar-hide overflow-x-auto scroll-smooth snap-x snap-mandatory space-x-5">
                            @foreach($similarPeople as $person)
                                <div class="flex-shrink-0 w-full sm:w-1/3 lg:w-1/6">
                                    <x-people.card :person="$person"/>
                                </div>
                            @endforeach
                        </div>

                    </x-carousel-pagination>
                </x-base.section>
            @endif
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
