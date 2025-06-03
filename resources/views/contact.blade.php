<x-app titleName="{{ $titleName }}">
    @push('styles')
    <style>
        .contact-bubble {
            @apply bg-violet-100 text-violet-800 p-6 rounded-3xl;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .contact-bubble:hover {
            @apply bg-violet-200 transform scale-[1.02];
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .map-container {
            @apply rounded-3xl overflow-hidden shadow-xl;
            height: 300px;
        }
    </style>
    @endpush

    <!-- Hero Section -->
    <section class="hero rounded-b-[4rem] md:rounded-b-[8rem] overflow-hidden relative">
        <div class="absolute inset-0 bg-violet-900/30"></div>
        <img src="{{ asset('img/lower silhouette.png') }}" alt="" class="w-full h-[35vh] md:h-[40vh] object-cover">
        <div class="absolute inset-0 flex justify-center items-end 2xl:pb-8">
            <h1 class="text-4xl md:text-6xl font-bold text-white drop-shadow-lg">Get in Touch</h1>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <!-- About Blurb -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-stone-800 mb-4">Quick<span class="text-violet-700">Pick</span></h2>
            <p class="text-stone-600 max-w-3xl mx-auto text-lg">
                Fast, friendly takeaway food designed for people on the go. Fresh, delicious meals served quickly 
                so you can pick your food, eat well, and get moving. Tasty, hassle-free food—fast.
            </p>
        </div>

        <!-- Contact Methods - Bubble Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <!-- Location -->
            <a href="https://maps.app.goo.gl/sBLgL9WfM917LyUP8" target="_blank" class="contact-bubble text-center">
                <div class="bg-violet-700 text-white p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Our Location</h3>
                <p class="text-stone-600">Dallu - 15, Kathmandu, Nepal</p>
                <p class="text-violet-700 mt-2 text-sm font-medium">View on Map →</p>
            </a>

            <!-- Phone -->
            <div class="contact-bubble text-center">
                <div class="bg-violet-700 text-white p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Call Us</h3>
                <div class="space-y-1">
                    <p class="text-stone-600">Nabin: 9861748449 | 9820150635</p>
                    <p class="text-stone-600">Bibek: 9767251739</p>
                </div>
            </div>

            <!-- Email -->
            <a href="mailto:quickpick1290@gmail.com" class="contact-bubble text-center">
                <div class="bg-violet-700 text-white p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Email Us</h3>
                <p class="text-stone-600">quickpick1290@gmail.com</p>
                <p class="text-violet-700 mt-2 text-sm font-medium">Send Message →</p>
            </a>

            <!-- Hours -->
            <div class="contact-bubble text-center">
                <div class="bg-violet-700 text-white p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Opening Hours</h3>
                <div class="space-y-1">
                    <p class="text-stone-600">Sunday-Saturday</p>
                    <p class="text-stone-600 font-medium">8:00 AM - 9:00 PM</p>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="mb-16">
            <h2 class="text-2xl font-bold text-stone-800 mb-6 text-center">Find Us on the Map</h2>
            <div class="map-container rounded-4xl overflow-hidden shadow-lg">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14128.186683870072!2d85.28259279999999!3d27.71584525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1900508c8307%3A0x1e3a78f3323af523!2sQuickPick!5e0!3m2!1sen!2snp!4v1748898108616!5m2!1sen!2snp" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>

        <!-- Social Proof/Call to Action -->
        <div class="text-center bg-violet-50 rounded-3xl p-8 md:p-12">
            <h2 class="text-2xl md:text-3xl font-bold text-stone-800 mb-4">Craving QuickPick?</h2>
            <p class="text-stone-600 mb-6 max-w-2xl mx-auto">We're just a call or visit away! Come experience our fast, fresh flavors today.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="tel:9861748449" class="bg-violet-700 text-white px-6 py-3 rounded-full font-medium hover:bg-violet-800 transition flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Call Now
                </a>
                <a href="https://maps.app.goo.gl/sBLgL9WfM917LyUP8" target="_blank" class="border border-violet-700 text-violet-700 px-6 py-3 rounded-full font-medium hover:bg-violet-50 transition flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Get Directions
                </a>
            </div>
        </div>
    </section>
</x-app>