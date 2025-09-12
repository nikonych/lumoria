<x-layouts.app>
    <div class="mx-24 mt-12">
        @auth
            <x-home.show/>
        @endauth
        @guest
            <x-gast.show/>
        @endguest
    </div>
</x-layouts.app>
