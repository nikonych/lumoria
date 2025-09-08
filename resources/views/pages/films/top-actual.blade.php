<x-layouts.app>
    <div class="mx-24 mt-12">
        <p class="text-indigo-400 text-sm"><a href="/films" class="font-light cursor-pointer">Filme</a> / <a
                href="/films/top-actual" class="font-semibold cursor-pointer">Top - aktuell</a></p>
        <div class="flex justify-between items-end">
            <h2 class="text-5xl mt-8">Top - aktuell</h2>
            <div class="flex gap-1.5 items-center">
                <p class="">Sortieren nach</p>
                <div class="relative inline-block">
                    <button id="dropdownButton" class="inline-flex w-full font-light text-sm justify-center items-center gap-x-1.5 rounded-md bg-input-dark px-3 py-1.5 focus:outline-none cursor-pointer">
                        Hoch bis niedrig
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
            </div>
        </div>
        <div class="mt-10">
            <div class="space-y-2.5">
                @for($i = 0; $i < 10; $i++)
                    <x-films.movie-card/>
                @endfor
            </div>
        </div>
    </div>

    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownIcon = document.getElementById('dropdownIcon');

        dropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDropdown();
        });

        // Закрытие при клике вне дропдауна
        document.addEventListener('click', function(e) {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                closeDropdown();
            }
        });

        // Обработка выбора пункта меню
        dropdownMenu.addEventListener('click', function(e) {
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
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDropdown();
            }
        });
    </script>
</x-layouts.app>
