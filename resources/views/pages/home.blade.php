<x-app>
    <x-header title="gg" description="gggg"/>
    <div class="mx-24 mt-12">
        @auth
            <x-home/>
        @endauth
        @guest
            <x-gast-page/>
        @endguest
    </div>
</x-app>
