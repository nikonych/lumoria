@props(['items', 'perPage' => 4])

@php
    $items = collect($items);
@endphp

@if ($items->count() > $perPage)
    <div x-data="{
        currentPage: 1,
        perPage: {{ $perPage }},
        totalItems: {{ $items->count() }},
        get totalPages() {
            return Math.ceil(this.totalItems / this.perPage)
        },
        scrollToPage() {
            const container = this.$refs.container;
            if (!container) return;
            const scrollLeft = (this.currentPage - 1) * container.clientWidth;
            container.scrollTo({ left: scrollLeft, behavior: 'smooth' });
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.scrollToPage();
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.scrollToPage();
            }
        },
        goToPage(page) {
            this.currentPage = page;
            this.scrollToPage();
        }
    }">

        {{ $slot }}

        <x-base.pagination />

    </div>
@else
    {{ $slot }}
@endif
