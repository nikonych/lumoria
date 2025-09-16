@if ($paginator->hasPages())
    <div class="flex justify-start items-center space-x-2.5 mt-8">
        {{-- Previous Page Button --}}
        <button wire:click="previousPage"
                {{ $paginator->onFirstPage() ? 'disabled' : '' }}
                class="flex items-center justify-center w-8 h-8 rounded-sm border border-indigo-700 text-gray-300 transition-colors hover:bg-gray-800 disabled:opacity-40 disabled:cursor-not-allowed">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Page Number Buttons --}}
        @if (is_array($paginator->links()->elements))
            @foreach ($paginator->links()->elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="flex items-center justify-center w-8 h-8 text-gray-500">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="flex items-center justify-center w-8 h-8 rounded-sm border bg-indigo-600 border-indigo-600 text-white text-sm font-medium">
                                <span>{{ $page }}</span>
                            </button>
                        @else
                            <button wire:click="gotoPage({{ $page }})"
                                    class="flex items-center justify-center w-8 h-8 rounded-sm border border-indigo-700 text-gray-300 hover:bg-gray-800 text-sm font-medium transition-colors">
                                <span>{{ $page }}</span>
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endif

        {{-- Next Page Button --}}
        <button wire:click="nextPage"
                {{ !$paginator->hasMorePages() ? 'disabled' : '' }}
                class="flex items-center justify-center w-8 h-8 rounded-sm border border-indigo-700 text-gray-300 transition-colors hover:bg-gray-800 disabled:opacity-40 disabled:cursor-not-allowed">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
@endif
