<div>
    <div class="space-y-5">
        @foreach ($reviews as $review)
            <x-movies.details.review-card :review="$review" />
        @endforeach
    </div>

    <x-pagination :paginator="$reviews" />
</div>
