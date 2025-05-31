<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuickPick - Fast, Friendly Takeaway Food</title>
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="QuickPick - Fast, Friendly Takeaway Food" />
    <meta property="og:description" content="Join us for fresh, delicious meals quickly and conveniently. Perfect for people on the go!" />
    <meta property="og:image" content="{{ asset('img/Final Rectangle white.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="QuickPick" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="QuickPick - Fast, Friendly Takeaway Food" />
    <meta name="twitter:description" content="Join us for fresh, delicious meals quickly and conveniently. Perfect for people on the go!" />
    <meta name="twitter:image" content="{{ asset('img/Final Rectangle white.png') }}" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom styles for animations and layout */
        body {
            font-family: 'Arial', sans-serif;
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        .slide-up {
            animation: slideUp 0.5s ease-in-out forwards;
            opacity: 0;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .icon {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }

        .hero {
            background-image: url('https://source.unsplash.com/1600x900/?food,takeaway');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .specialty-card {
            transition: transform 0.3s;
        }

        .specialty-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        
        <!-- Navigation -->
        <nav class="bg-violet-900 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="text-white text-2xl font-bold">
                            <img src="{{ asset('img/Final Rectangle white.png') }}" alt="QuickPick Logo" class="h-10">
                        </a>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
                        <a href="{{ route('home') }}" class="text-violet-200 hover:text-white px-3 py-2 rounded-md text-lg font-medium">Home</a>
                        <a href="{{ route('menu') }}" class="bg-violet-800 text-white px-3 py-2 rounded-md text-lg font-medium">Menu</a>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-violet-200 hover:text-white hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-button">
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
                    <a href="{{ route('home') }}" class="text-violet-200 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Home</a>
                    <a href="{{ route('menu') }}" class="bg-violet-800 text-white block px-3 py-2 rounded-md text-base font-medium">Menu</a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <header class="hero">
            <div class="hero-content">
                <h1 class="text-5xl font-bold fade-in">Welcome to QuickPick!</h1>
                <p class="mt-4 text-lg fade-in">Fast, friendly takeaway food designed for people on the go!</p>
                <a href="{{ route('menu') }}" class="mt-6 inline-block bg-white text-violet-800 px-6 py-3 rounded-md font-semibold hover:bg-violet-200 transition duration-300 bounce">Grab Your Meal Now!</a>
            </div>
        </header>

        <!-- About Section -->
        <section class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-violet-900 text-center mb-8">About Us</h2>
            <div class="flex flex-col items-center">
                <img src="https://source.unsplash.com/300x200/?restaurant" alt="About QuickPick" class="rounded-lg mb-4">
                <p class="text-lg text-gray-700 text-center mb-4 slide-up">At QuickPick, we serve fresh, delicious meals quickly and conveniently. Whether you're grabbing lunch between meetings or dinner on the way home, we've got you covered!</p>
                <p class="text-lg text-gray-700 text-center slide-up">Our motto? Pick your food, eat well, and get moving! Because life is too short for boring meals!</p>
            </div>
        </section>

        <!-- Specialties Section -->
        <section class="bg-gray-200 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-violet-900 text-center mb-8">Our Specialties</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow-md p-6 text-center specialty-card">
                        <img src="https://source.unsplash.com/100x100/?salad" alt="Speedy Salads" class="icon mx-auto">
                        <h3 class="font-semibold text-violet-800 text-xl">Speedy Salads</h3>
                        <p class="text-gray-600">Fresh, crisp, and ready in a flash! Perfect for a quick health boost.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 text-center specialty-card">
                        <img src="https://source.unsplash.com/100x100/?bowl" alt="Bountiful Bowls" class="icon mx-auto">
                        <h3 class="font-semibold text-violet-800 text-xl">Bountiful Bowls</h3>
                        <p class="text-gray-600">Hearty and wholesome, our bowls are packed with flavor and nutrition!</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 text-center specialty-card">
                        <img src="https://source.unsplash.com/100x100/?wrap" alt="Tasty Wraps" class="icon mx-auto">
                        <h3 class="font-semibold text-violet-800 text-xl">Tasty Wraps</h3>
                        <p class="text-gray-600">Wrap it up! Our wraps are deliciously convenient for on-the-go munching.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fun Facts Section -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-violet-900 text-center mb-8">Fun Facts About QuickPick</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <h3 class="font-semibold text-violet-800 text-xl">🌟 Over 1000 Meals Served!</h3>
                        <p class="text-gray-600">We’ve been serving delicious meals to happy customers since day one!</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <h3 class="font-semibold text-violet-800 text-xl">🚀 Fastest Service in Town!</h3>
                        <p class="text-gray-600">Our team is trained to get your food to you in record time!</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <h3 class="font-semibold text-violet-800 text-xl">🥗 Fresh Ingredients Daily!</h3>
                        <p class="text-gray-600">We source our ingredients from local farms to ensure quality!</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-violet-900 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p>&copy; {{ date('Y') }} QuickPick. All rights reserved.</p>
                </div>
            </div>
        </footer>

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
    </div>
</body>
</html>