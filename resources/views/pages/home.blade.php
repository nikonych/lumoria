<x-layouts.app>
    @auth
        <x-home.show/>
    @else
        <x-guest.show/>
    @endauth
</x-layouts.app>
