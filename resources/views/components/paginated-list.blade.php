@props(['items', 'perPage' => 3])

@php
    $items = collect($items);
@endphp

<div x-data="{
    currentPage: 1,
    perPage: {{ $perPage }},
    totalItems: {{ $items->count() }},

    get totalPages() {
        return Math.ceil(this.totalItems / this.perPage)
    },

    nextPage() {
        if (this.currentPage < this.totalPages) {
            this.currentPage++;
        }
    },

    prevPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
        }
    },

    goToPage(page) {
        this.currentPage = page;
    }
}">

    <div class="space-y-5">

        @foreach ($items as $loop => $review)
            <div x-show="($loop->index >= (currentPage - 1) * perPage) && ($loop->index < currentPage * perPage)" x-transition>
                <x-movies.review-card :review="$review" />
            </div>
        @endforeach
    </div>

    @if ($items->count() > $perPage)
        <div class="w-full flex justify-center mt-8">
            <x-base.pagination />
        </div>
    @endif
</div>
