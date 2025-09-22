<div class="w-3/4" x-data="{ activeTab: 'favoriten' }">
    <div class="border-b border-indigo-950 mb-8">
        <nav class="-mb-px flex space-x-8">
            <button
                wire:click="$set('activeTab', 'favoriten')"
                class="py-4 px-1 border-b-2  text-lg whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'favoriten' ? 'border-indigo-500 text-slate-50' : 'border-transparent text-slate-400 hover:text-gray-300 hover:border-gray-300' }}">
                Favoriten
            </button>

            <button
                wire:click="$set('activeTab', 'sammlungen')"
                class="py-4 px-1 border-b-2  text-lg whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'sammlungen' ? 'border-indigo-500 text-slate-50' : 'border-transparent text-slate-400 hover:text-gray-300 hover:border-gray-300' }}">
                Sammlungen
            </button>

            <button
                wire:click="$set('activeTab', 'bewertungen')"
                class="py-4 px-1 border-b-2  text-lg whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'bewertungen' ? 'border-indigo-500 text-slate-50' : 'border-transparent text-slate-400 hover:text-gray-300 hover:border-gray-300' }}">
                Bewertungen
            </button>

            <button
                wire:click="$set('activeTab', 'freunde')"
                class="py-4 px-1 border-b-2  text-lg whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'freunde' ? 'border-indigo-500 text-slate-50' : 'border-transparent text-slate-400 hover:text-gray-300 hover:border-gray-300' }}">
                Freunde
            </button>

            <button
                wire:click="$set('activeTab', 'einstellungen')"
                class="py-4 px-1 border-b-2  text-lg whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'einstellungen' ? 'border-indigo-500 text-slate-50' : 'border-transparent text-slate-400 hover:text-gray-300 hover:border-gray-300' }}">
                Einstellungen
            </button>
        </nav>
    </div>

    <div class="min-h-screen">
        @if($activeTab === 'favoriten')
            @include('profile.tabs.favoriten')
        @elseif($activeTab === 'sammlungen')
            @include('profile.tabs.sammlungen')
        @elseif($activeTab === 'bewertungen')
            @include('profile.tabs.bewertungen')
        @elseif($activeTab === 'freunde')
            @include('profile.tabs.freunde')
        @elseif($activeTab === 'einstellungen')
            @include('profile.tabs.einstellungen')
        @endif
    </div>
</div>
