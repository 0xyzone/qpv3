<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-white text-2xl font-bold">
                    <img src="{{ asset('img/Final.png') }}" alt="QuickPick Logo" class="h-10">
                </a>
            </div>
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-violet-800 text-white hover:text-white' : '' }} text-violet-400 hover:text-violet-800 px-3 py-2 rounded-md text-lg font-medium">Home</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'bg-violet-800 text-white hover:text-white' : '' }} text-violet-400 hover:text-violet-800 px-3 py-2 rounded-md text-lg font-medium">Contact Us</a>
                <a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'bg-violet-800 text-white hover:text-white' : '' }} text-violet-400 hover:text-violet-800 px-3 py-2 rounded-md text-lg font-medium">Menu</a>
            </div>
            <div class="-mr-2 flex items-center sm:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-violet-800 hover:text-white hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-current" aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-button">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-violet-800 text-white' : '' }} text-violet-400 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Home</a>

            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'bg-violet-800 text-white' : '' }} text-violet-400 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Contact Us</a>
            
            <a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'bg-violet-800 text-white' : '' }} text-violet-400 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Menu</a>
        </div>
    </div>
</nav>
@push('scripts')
<!-- Mobile menu toggle script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            mobileMenu.classList.toggle('hidden');
        });
    });

</script>
@endpush
