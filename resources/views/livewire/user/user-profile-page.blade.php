<div class="mr-24" x-data="{ activeTab: 'favoriten' }">
    <div class="border-b border-indigo-950 mb-8">
        <nav class="flex space-x-8">
            <button
                wire:click="setActiveTab('favoriten')"
                class="py-4 px-1 border-b-2 text-lg whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'favoriten' ? 'border-indigo-500 text-slate-50' : 'border-transparent text-slate-400 hover:text-gray-300 hover:border-gray-300' }}">
                Favoriten
            </button>

            <button
                wire:click="setActiveTab('sammlungen')"
                class="py-4 px-1 border-b-2 text-lg whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'sammlungen' ? 'border-indigo-500 text-slate-50' : 'border-transparent text-slate-400 hover:text-gray-300 hover:border-gray-300' }}">
                Sammlungen
            </button>

            <button
                wire:click="setActiveTab('bewertungen')"
                class="py-4 px-1 border-b-2 text-lg whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'bewertungen' ? 'border-indigo-500 text-slate-50' : 'border-transparent text-slate-400 hover:text-gray-300 hover:border-gray-300' }}">
                Bewertungen
            </button>

        </nav>
    </div>

    <div class="min-h-screen">
        @if($activeTab === 'favoriten')
            @include('user.tabs.favoriten', ['user' => $user])
        @elseif($activeTab === 'sammlungen')
            @include('user.tabs.sammlungen', ['user' => $user])
        @elseif($activeTab === 'bewertungen')
            @include('user.tabs.bewertungen', ['user' => $user])
        @endif
    </div>
</div>
