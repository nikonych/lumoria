<div class="mb-24">
    <p class="mt-9 text-3xl font-family-helvetica">{{ $user->name }}s Bewertungen</p>
    <div class="space-y-5 mt-5">
        @foreach ($this->reviews as $review)
            <x-profile.review-card :review="$review" />
        @endforeach
    </div>

    <x-pagination :paginator="$this->reviews" />
</div>
