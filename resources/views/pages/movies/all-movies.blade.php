<x-layouts.app>
    <div class="mx-24 mt-12">
        <p class="text-indigo-400 text-sm"><a href="/movies" class="font-light cursor-pointer">Filme</a> / <a
                href="/movies/top-actual" class="font-semibold cursor-pointer">Alle Filme</a></p>
        <div class="flex mt-8 space-x-10">
            <div class="w-3/12 p-6 rounded-lg text-white">
                <div class="flex items-center space-x-2.5 pb-4">
                    <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 2.39062C0 1.49219 0.703125 0.75 1.60156 0.75H18.3594C19.2578 0.75 20 1.49219 20 2.39062C20 2.78125 19.8438 3.13281 19.6094 3.40625L13.125 11.4141V17C13.125 17.7031 12.5391 18.25 11.8359 18.25C11.5625 18.25 11.2891 18.1719 11.0547 17.9766L7.46094 15.125C7.07031 14.8125 6.875 14.3828 6.875 13.9141V11.4141L0.351562 3.40625C0.117188 3.13281 0 2.78125 0 2.39062ZM2.10938 2.625L8.51562 10.4766C8.67188 10.6719 8.75 10.8672 8.75 11.0625V13.7578L11.25 15.75V11.0625C11.25 10.8672 11.2891 10.6719 11.4453 10.4766L17.8516 2.625H2.10938Z" fill="#F8FAFC"/>
                    </svg>
                    <p class="text-xl font-semibold">Filter</p>
                </div>

                <div class="space-y-6 mt-4">
                    <div class="relative inline-block w-full">
                        <button id="dropdownButton" class="inline-flex w-full font-light text-sm justify-center items-center gap-x-1.5 rounded-md bg-input-dark px-3 py-1.5 focus:outline-none cursor-pointer">

                            <svg viewBox="0 0 20 20" fill="currentColor" class="-mr-1 ml-8 size-5 text-indigo-400 transition-transform duration-200" id="dropdownIcon">
                                <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>

                        <div id="dropdownMenu" class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-input-dark ring-1 ring-white/10 shadow-lg transition-all duration-200 transform opacity-0 scale-95">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Hoch bis niedrig</a>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Niedrig bis hoch</a>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Alphabetisch A-Z</a>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Alphabetisch Z-A</a>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Neueste zuerst</a>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Älteste zuerst</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-300">Produktionsland</label>
                        <select id="country" name="country" class="w-full bg-input-dark rounded-md">
                            <option>Land auswählen</option>
                            <option>USA</option>
                            <option>Deutschland</option>
                            <option>Großbritannien</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300">Erscheinungsjahr</label>
                        <div class="flex items-center gap-2 mt-1">
                            <input type="number" placeholder="Von" class="w-full text-base bg-input-dark/80 border-transparent focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <span>-</span>
                            <input type="number" placeholder="Bis" class="w-full text-base bg-input-dark/80 border-transparent focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-300">Altersfreigabe</h4>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-2">
                            <label class="inline-flex items-center"><input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500"><span class="ml-2">0</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500"><span class="ml-2">6</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500"><span class="ml-2">12</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500"><span class="ml-2">16</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500"><span class="ml-2">18</span></label>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-300 underline text-indigo-400 cursor-pointer">Genre</h4>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-2">
                            <label class="inline-flex items-center"><input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500"><span class="ml-2">Action</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500"><span class="ml-2">Komödie</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500"><span class="ml-2">Animation</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500"><span class="ml-2">Kriegsfilm</span></label>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-300">Bewertungen</h4>
                        <div class="space-y-2 mt-2">
                            <label class="inline-flex items-center w-full">
                                <input type="checkbox" class="h-4 w-4 rounded bg-input-dark/80 border-transparent text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 flex items-center">
                        <svg class="w-4 h-4 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="ml-2">4 und mehr</span>
                    </span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button class="w-full bg-gray-600/50 hover:bg-gray-500/50 text-white font-semibold py-2 px-4 rounded-md transition-colors">
                            Zurücksetzen
                        </button>
                        <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition-colors">
                            Anwenden
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-9/12">
                <div class="flex justify-between items-end">
                    <h2 class="text-5xl">Alle Filme</h2>
                    <div class="flex gap-1.5 items-center">
                        <p class="">Sortieren nach</p>
                        <div class="relative inline-block">
                            <button id="dropdownButton"
                                    class="inline-flex w-full font-light text-sm justify-center items-center gap-x-1.5 rounded-md bg-input-dark px-3 py-1.5 focus:outline-none cursor-pointer">
                                Hoch bis niedrig
                                <svg viewBox="0 0 20 20" fill="currentColor"
                                     class="-mr-1 ml-8 size-5 text-indigo-400 transition-transform duration-200"
                                     id="dropdownIcon">
                                    <path
                                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" fill-rule="evenodd"/>
                                </svg>
                            </button>

                            <div id="dropdownMenu"
                                 class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-input-dark ring-1 ring-white/10 shadow-lg transition-all duration-200 transform opacity-0 scale-95">
                                <div class="py-1">
                                    <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Hoch
                                        bis niedrig</a>
                                    <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Niedrig
                                        bis hoch</a>
                                    <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Alphabetisch
                                        A-Z</a>
                                    <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Alphabetisch
                                        Z-A</a>
                                    <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Neueste
                                        zuerst</a>
                                    <a href="#" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">Älteste
                                        zuerst</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-10">
                    <div class="space-y-2.5">
                        @for($i = 0; $i < 10; $i++)
                            <x-movies.movie-card-list/>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownIcon = document.getElementById('dropdownIcon');

        dropdownButton.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleDropdown();
        });

        // Закрытие при клике вне дропдауна
        document.addEventListener('click', function (e) {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                closeDropdown();
            }
        });

        // Обработка выбора пункта меню
        dropdownMenu.addEventListener('click', function (e) {
            if (e.target.tagName === 'A') {
                e.preventDefault();
                dropdownButton.querySelector('span') || dropdownButton.insertBefore(document.createElement('span'), dropdownButton.querySelector('svg'));
                dropdownButton.firstChild.textContent = e.target.textContent;
                closeDropdown();
            }
        });

        function toggleDropdown() {
            if (dropdownMenu.classList.contains('hidden')) {
                openDropdown();
            } else {
                closeDropdown();
            }
        }

        function openDropdown() {
            dropdownMenu.classList.remove('hidden');
            setTimeout(() => {
                dropdownMenu.classList.remove('opacity-0', 'scale-95');
                dropdownMenu.classList.add('opacity-100', 'scale-100');
                dropdownIcon.style.transform = 'rotate(180deg)';
            }, 10);
        }

        function closeDropdown() {
            dropdownMenu.classList.remove('opacity-100', 'scale-100');
            dropdownMenu.classList.add('opacity-0', 'scale-95');
            dropdownIcon.style.transform = 'rotate(0deg)';
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 200);
        }

        // Закрытие по клавише Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDropdown();
            }
        });
    </script>
</x-layouts.app>
