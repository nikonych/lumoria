
@props(['title', 'id'])

<section x-data="{ isOpen: true }" id="{{$id}}" class="mb-16">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-bold">{{ $title }}</h2>

        <button @click="isOpen = !isOpen" class="hover:text-indigo-700 cursor-pointer transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="w-8 h-8 transition-transform duration-300"
                 :class="{ 'rotate-180': !isOpen }">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
            </svg>
        </button>
    </div>

    <div x-show="isOpen" x-transition>
        {{ $slot }}
    </div>
</section>
