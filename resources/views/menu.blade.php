<x-app titleName="{{ $titleName }}">
    <!-- Menu Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-4xl font-bold text-violet-900 mb-8 text-center">Our Menu</h1>

            <!-- Search Functionality -->
            <div class="mb-6">
                <input type="text" id="search" placeholder="Search..." class="block w-full p-3 border border-violet-300 rounded-2xl focus:outline-none focus:ring focus:ring-violet-500" />
            </div>

            <!-- View Toggle Button -->
            <div class="mb-4 flex justify-end">
                <button id="toggleView" class="px-4 py-2 text-sm font-medium text-violet-700 rounded-md focus:outline-none cursor-pointer hover:bg-violet-200 duration-300">
                    <!-- Button text will be set by JavaScript -->
                </button>
            </div>

            <!-- Tabs for Categories -->
            <div class="mb-4">
                <div class="flex overflow-x-auto space-x-4 py-4">
                    <button class="tab-button px-4 py-2 text-sm font-medium text-violet-700 rounded-md focus:outline-none cursor-pointer hover:bg-violet-200 hover:scale-110 duration-300 bg-violet-200 flex-shrink-0" data-tab="tabAll">
                        All Items
                    </button>
                    @foreach($categories as $index => $category)
                    <button class="tab-button px-4 py-2 text-sm font-medium rounded-md focus:outline-none cursor-pointer hover:bg-violet-200 hover:scale-110 duration-300 bg-white flex-shrink-0" data-tab="tab{{ $index }}">
                        {{ $category->name }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Menu Items -->
            <div id="menuItems" class="grid-view">
                <!-- All Items Tab -->
                <div class="tab-content block" id="tabAll">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($categories as $category)
                        @foreach($category->items as $item)
                        <div class="menu-item bg-white rounded-4xl shadow-lg overflow-hidden border border-violet-200 hover:shadow-xl transition-shadow duration-300 flex flex-col">
                            <div class="relative h-64 aspect-square">
                                <img src="{{ $item->photo_path ? asset('storage/' . $item->photo_path) : asset('img/Food placements.png') }}" alt="{{ $item->name }}" class="absolute inset-0 w-full h-full object-cover">
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
                        @endforeach
                    </div>
                </div>

                @foreach($categories as $index => $category)
                <div class="tab-content hidden" id="tab{{ $index }}">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($category->items as $item)
                        <div class="menu-item bg-white rounded-4xl shadow-lg overflow-hidden border border-violet-200 hover:shadow-xl transition-shadow duration-300 flex flex-col">
                            <div class="relative h-64 aspect-square">
                                <img src="{{ $item->photo_path ? asset('storage/' . $item->photo_path) : asset('img/Food placements.png') }}" alt="{{ $item->name }}" class="absolute inset-0 w-full h-full object-cover">
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
            // Initialize variables
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            const toggleViewButton = document.getElementById('toggleView');
            const menuItemsContainer = document.getElementById('menuItems');

            // Get saved view preference or default to grid view
            let isGridView = localStorage.getItem('menuViewPreference') !== 'list';

            // Set initial view based on saved preference
            function setInitialView() {
                if (isGridView) {
                    menuItemsContainer.classList.add('grid-view');
                    toggleViewButton.textContent = 'Switch to List View';
                } else {
                    menuItemsContainer.classList.add('list-view');
                    toggleViewButton.textContent = 'Switch to Grid View';
                }
            }

            // Initialize the view
            setInitialView();

            // Tab functionality
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

            searchInput.addEventListener('input', filterMenu);

            function filterMenu() {
                const searchTerm = searchInput.value.toLowerCase();
                const activeTab = document.querySelector('.tab-content:not(.hidden)');
                const itemsToFilter = activeTab.id === 'tabAll' ?
                    document.querySelectorAll('.menu-item') :
                    activeTab.querySelectorAll('.menu-item');

                itemsToFilter.forEach(item => {
                    const itemName = item.querySelector('h3').textContent.toLowerCase();
                    item.style.display = itemName.includes(searchTerm) ? '' : 'none';
                });
            }

            // Toggle view functionality
            toggleViewButton.addEventListener('click', () => {
                isGridView = !isGridView;

                // Save preference to localStorage
                localStorage.setItem('menuViewPreference', isGridView ? 'grid' : 'list');

                if (isGridView) {
                    menuItemsContainer.classList.remove('list-view');
                    menuItemsContainer.classList.add('grid-view');
                    toggleViewButton.textContent = 'Switch to List View';
                } else {
                    menuItemsContainer.classList.remove('grid-view');
                    menuItemsContainer.classList.add('list-view');
                    toggleViewButton.textContent = 'Switch to Grid View';
                }

                // Refresh filtered items to apply new view
                filterMenu();
            });
        });

    </script>
    @endpush
    @push('styles')
    <style>
        .list-view .menu-item {
            display: flex !important;
            flex-direction: row;
            margin-bottom: 1.5rem;
            max-width: 100%;
            width: 100%;
        }

        .list-view .menu-item>div:first-child {
            width: 200px;
            min-width: 200px;
            height: 150px;
            margin-right: 1.5rem;
        }

        .list-view .menu-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 1rem 0 0 1rem;
        }

        .list-view .menu-item>div:last-child {
            flex: 1;
            padding: 1.5rem;
        }

        .list-view .grid {
            display: block !important;
        }

        .list-view .grid>div {
            max-width: none !important;
        }

    </style>
    @endpush
</x-app>
