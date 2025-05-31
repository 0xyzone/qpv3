<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodHub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header Section -->
    <header class="flex justify-between items-center p-5 bg-white shadow">
        <div class="text-3xl font-bold text-orange-500">FoodHub</div>
        <nav>
            <ul class="flex space-x-6">
                <li><a href="#" class="text-gray-700">Home</a></li>
                <li><a href="#" class="text-gray-700">Services</a></li>
                <li><a href="#" class="text-gray-700">Foods</a></li>
                <li><a href="#" class="text-gray-700">Contact</a></li>
                <li><a href="#" class="text-orange-500 font-semibold">Sign In</a></li>
                <li><a href="#" class="bg-orange-500 text-white px-4 py-2 rounded">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="bg-orange-100 py-20 text-center">
        <h1 class="text-4xl font-bold mb-4">Delicious Meals <span class="text-orange-500">Delivered to Your Door</span></h1>
        <p class="mb-6">Enjoy fresh, flavorful meals made with the finest ingredients, delivered direct to your door, every time.</p>
        <button class="bg-orange-500 text-white px-6 py-2 rounded">Order Now</button>
        <button class="bg-white text-orange-500 border border-orange-500 px-6 py-2 rounded ml-4">Learn More</button>
    </section>

    <!-- Popular Items Section -->
    <section class="py-20">
        <h2 class="text-3xl font-bold text-center mb-10">Our Popular Items</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-5">
            <div class="bg-white rounded shadow p-5 text-center">
                <h3 class="text-xl font-semibold">Four Cheese Pizza</h3>
                <p>Free Delivery for first order</p>
                <button class="bg-orange-500 text-white px-4 py-2 rounded mt-4">Order Now</button>
            </div>
            <div class="bg-white rounded shadow p-5 text-center">
                <h3 class="text-xl font-semibold">Margherita Pizza</h3>
                <p>Get 10% discount on Sunday</p>
                <button class="bg-orange-500 text-white px-4 py-2 rounded mt-4">Order Now</button>
            </div>
            <div class="bg-white rounded shadow p-5 text-center">
                <h3 class="text-xl font-semibold">Hot Dog</h3>
                <p>Get 20% off on your order</p>
                <button class="bg-orange-500 text-white px-4 py-2 rounded mt-4">Order Now</button>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="bg-gray-100 py-20">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Inspired by Taste, Built on <span class="text-orange-500">Quality</span></h2>
            <p>Passionate about quality, we create delicious meals made with fresh ingredients and care.</p>
            <p class="mt-4">Fresh Food, Fast Delivery</p>
            <p>10% off every Sunday for all food items</p>
            <button class="mt-6 bg-orange-500 text-white px-4 py-2 rounded">Learn More</button>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-20">
        <h2 class="text-3xl font-bold text-center mb-10">Bringing Quality and Convenience to <span class="text-orange-500">Your Table</span></h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 px-5">
            <div class="bg-white rounded shadow p-5 text-center">
                <h3 class="text-xl font-semibold">Mc White Coffee</h3>
                <button class="bg-orange-500 text-white px-4 py-2 rounded mt-4">Order Now</button>
            </div>
            <div class="bg-white rounded shadow p-5 text-center">
                <h3 class="text-xl font-semibold">Double Burger</h3>
                <button class="bg-orange-500 text-white px-4 py-2 rounded mt-4">Order Now</button>
            </div>
            <div class="bg-white rounded shadow p-5 text-center">
                <h3 class="text-xl font-semibold">Hawaiian Pizza</h3>
                <button class="bg-orange-500 text-white px-4 py-2 rounded mt-4">Order Now</button>
            </div>
            <div class="bg-white rounded shadow p-5 text-center">
                <h3 class="text-xl font-semibold">Pepperoni Pizza</h3>
                <button class="bg-orange-500 text-white px-4 py-2 rounded mt-4">Order Now</button>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="bg-white py-20 text-center">
        <h2 class="text-3xl font-bold mb-6">What Our Customers Say About Us</h2>
        <p>"The website was easy to use, food arrived hot and fresh, and the delivery driver was friendly!"</p>
        <div class="mt-4 flex items-center justify-center">
            <img src="path/to/image.jpg" alt="Customer" class="w-16 h-16 rounded-full mr-4">
            <div>
                <h4 class="font-semibold">Albart Hobson</h4>
                <p>Manager of Restaurant</p>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-orange-100 py-20 text-center">
        <h2 class="text-3xl font-bold mb-4">Subscribe to Our <span class="text-orange-500">Newsletter</span></h2>
        <p>Subscribe to our newsletter for exclusive offers, new updates, and delicious discounts delivered straight to you.</p>
        <div class="mt-5">
            <input type="email" placeholder="Enter your email" class="py-2 px-4 rounded" required>
            <button class="bg-orange-500 text-white px-4 py-2 rounded">Subscribe</button>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-10">
        <div class="container mx-auto text-center">
            <p>© 2023 FoodHub | All Rights Reserved</p>
            <div class="flex justify-center mt-4 space-x-4">
                <a href="#" class="text-white">Facebook</a>
                <a href="#" class="text-white">Twitter</a>
                <a href="#" class="text-white">Instagram</a>
            </div>
            <div class="mt-4">
                <p>New York, NY 10017</p>
                <p>(123) 555-1234</p>
                <p>foodhub@gmail.com</p>
            </div>
        </div>
    </footer>
</body>
</html>
