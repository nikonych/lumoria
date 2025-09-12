@props(['trailer_url'])
<div>
    @if($trailer_url)

        <div class="aspect-video mx-28">
            <iframe
                src="{{ str_replace('watch?v=', 'embed/', $trailer_url) }}"
                title="Trailer"
                class="w-full h-full"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    @endif
</div>
