@props(['genres'])

<h2 class="text-5xl">Genre</h2>
<x-movies.genres-cards-list :genres="$genres" />
