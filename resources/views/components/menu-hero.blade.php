<section class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-lg md:text-3xl font-bold text-stone-800">Our <span>Popular</span> Items</h2>
            <p class="text-stone-500 text-xs md:text-sm pr-4 md:pr-0">Explore our delicious offerings crafted with care and passion.</p>
        </div>
        <a href="{{ route('menu') }}" class="bg-violet-600 p-4 rounded-full text-white lg:text-lg text-xs shrink-0">View All <svg class="w-6 h-6 md:w-10 md:h-10 p-2 rounded-full ml-2 inline bg-white " fill="#333" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg></a>
    </div>
    <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-6">
        @foreach ($popularItems as $item)
        <style>
            @media (width >= 40rem) {
                #item-{{ $item['id'] }} {
                    grid-column: span {{ $item['colspan'] }} / span {{ $item['colspan'] }};
                }
            }
        </style>
        <div class="overflow-hidden w-full bg-stone-800 text-stone-300 rounded-4xl shadow-2xl flex justify-between items-center relative flex-grow col-span-1" id="item-{{ $item['id'] }}">
            <div class="p-8 w-10/12 flex-grow">
                <h3 class="text-lg font-semibold">{{ $item['name'] }}</h3>
                <p class="text-stone-500 w-8/12 text-sm">{{ $item['description'] }}</p>
            </div>
            <div class="">
                <img src="{{ $item['image'] }}" alt="" class="absolute right-0 lg:h-40 top-1/2 -translate-y-1/2 h-full object-cover">
            </div>
        </div>
        @endforeach
    </div>
</section>
