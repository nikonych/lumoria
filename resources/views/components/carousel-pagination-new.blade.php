@props(['items', 'perPage' => 4])

@php
    $isPaginator = $items instanceof \Illuminate\Pagination\LengthAwarePaginator;
    $itemsCollection = $isPaginator ? $items->getCollection() : collect($items);
    $totalItems = $isPaginator ? $items->total() : $itemsCollection->count();
@endphp

@if ($totalItems > $perPage)
    <div x-data="{
        currentPage: {{ $isPaginator ? $items->currentPage() : 1 }},
        perPage: {{ $perPage }},
        totalItems: {{ $totalItems }},
        get totalPages() {
            return {{ $isPaginator ? $items->lastPage() : 'Math.ceil(this.totalItems / this.perPage)' }}
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
    }"
    class="max-w-5xl">

        {{ $slot }}

        <x-pagination :paginator="$items"/>

    </div>
@else
    {{ $slot }}
@endif
