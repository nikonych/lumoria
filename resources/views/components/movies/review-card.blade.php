@props(['review'])

<div class="bg-bg-card rounded-sm h-full">
    <div class="flex justify-between pt-5 px-7">
        <div class="flex items-center space-x-3 border-b pb-2.5 border-indigo-950 w-full">
            <img class="rounded-full w-14 h-14" src="{{$review->user->profile_image}}" alt="{{$review->user->name}}">
            <div class="flex flex-col">
                <span class="text-indigo-200 text-lg">{{$review->user->name}}</span>
                <span class="font-light text-sm">{{ $review->created_at->format('j, M Y') }}</span>
            </div>
        </div>
        <x-base.stars :rating="$review->rating" spacing="space-x-3"/>
    </div>
    <div class="flex flex-col px-7">
        <span class="text-lg text-indigo-200 mt-2.5">{{$review->title}}</span>
        <span class="mt-4 font-light pb-5">{{$review->description}}</span>
    </div>
</div>
