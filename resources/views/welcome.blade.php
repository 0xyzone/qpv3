<x-app>
    @push('styles')
    <style>
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

            0%,
            20%,
            50%,
            80%,
            100% {
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
            /* background-image: url('{{ asset('img/hero-bg.jpg') }}'); */
            /* background-size: cover; */
            /* background-position: center; */
            height: full;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
        }

        /* .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        } */

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
    @endpush
    <!-- Hero Section -->
    <div class="hero rounded-b-[4rem] md:rounded-b-[8rem] overflow-hidden">
        <img src="{{ asset('img/hero-bg.jpg') }}" alt="" class="w-full h-[35vh] md:h-full object-cover">
        <!-- <div class="hero-content h-full">
            {{-- <h1 class="text-5xl font-bold fade-in">Welcome to QuickPick!</h1>
            <p class="mt-4 text-lg fade-in">Fast, friendly takeaway food designed for people on the go!</p>
            <a href="{{ route('menu') }}" class="mt-6 inline-block bg-white text-violet-800 px-6 py-3 rounded-md font-semibold hover:bg-violet-200 transition duration-300 bounce">Grab Your Meal Now!</a> --}}
        </div> -->
    </div>

    <x-menu-hero :popularItems="$popularItems" />
    <x-reviews />
    <x-faq />
    <x-socials />
</x-app>
