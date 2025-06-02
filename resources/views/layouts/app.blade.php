<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <title>QuickPick {{ isset($titleName) ? ' - ' . $titleName : '' }}</title>

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

    {{-- Google Fonts - Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Borel&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js', "resources/css/all.css"])
    @stack('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        h2 {
            font-family: 'Borel', cursive;
        }

    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">

        <!-- Navigation -->
        <x-nav />
        {{ $slot }}

        <!-- Footer -->
        <footer class="bg-violet-900 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p>&copy; {{ date('Y') }} QuickPick. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>
