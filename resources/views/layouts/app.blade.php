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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
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
