<x-app titleName="{{ $titleName }}">
    <!-- Menu Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-4xl font-bold text-violet-900 mb-8 text-center">Our Menu</h1>

            <!-- Search Functionality -->
            <div class="mb-6">
                <input type="text" id="search" placeholder="Search..." class="block w-full p-3 border border-violet-300 rounded-md focus:outline-none focus:ring focus:ring-violet-500" />
            </div>

            <!-- Tabs for Categories -->
            <div class="mb-4">
                <div class="flex overflow-x-auto space-x-4 py-4">
                    @foreach($categories as $index => $category)
                    <button class="tab-button px-4 py-2 text-sm font-medium text-violet-700 rounded-md focus:outline-none cursor-pointer hover:bg-violet-200 hover:scale-110 duration-300 {{ $index === 0 ? 'bg-violet-200' : 'bg-white' }} flex-shrink-0" data-tab="tab{{ $index }}">
                        {{ $category->name }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Menu Items -->
            <div id="menuItems">
                @foreach($categories as $index => $category)
                <div class="tab-content {{ $index === 0 ? 'block' : 'hidden' }}" id="tab{{ $index }}">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($category->items as $item)
                        <div class="menu-item bg-white rounded-4xl shadow-lg overflow-hidden border border-violet-200 hover:shadow-xl transition-shadow duration-300 flex flex-col">
                            <div class="relative w-full h-48">
                                <img src="{{ $item->photo_path ? asset($item->photo_path) : asset('img/Food placements.png') }}" alt="{{ $item->name }}" class="absolute inset-0 w-full h-full object-cover">
                            </div>
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="font-semibold text-violet-800 text-lg h-fit">{{ $item->name }}</h3>
                                @if($item->description)
                                <p class="text-sm text-gray-600 mt-1 flex-grow">{{ $item->description }}</p>
                                @endif
                                <span class="font-bold text-violet-700 text-lg mt-2">रु {{ number_format($item->price, 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    @push ('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetTab = button.getAttribute('data-tab');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('bg-violet-200');
                        btn.classList.add('bg-white');
                    });

                    // Show the selected tab content
                    document.getElementById(targetTab).classList.remove('hidden');
                    button.classList.add('bg-violet-200');
                    button.classList.remove('bg-white');
                });
            });

            // Search functionality
            const searchInput = document.getElementById('search');
            const menuItems = document.querySelectorAll('.menu-item');

            searchInput.addEventListener('input', filterMenu);

            function filterMenu() {
                const searchTerm = searchInput.value.toLowerCase();

                menuItems.forEach(item => {
                    const itemName = item.querySelector('h3').textContent.toLowerCase();
                    if (itemName.includes(searchTerm)) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            }
        });

    </script>
    @endpush
</x-app>
