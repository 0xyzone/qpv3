<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularItems = [
            [
                "id" => 1,
                "name" => "Special Momo",
                "description" => "Delicious steamed dumplings filled with a mix of vegetables and spices.",
                "price" => 150,
                "image" => asset('img/home/momo.png'),
                "colspan" => 5
            ],
            [
                "id" => 2,
                "name" => "Spicy Chicken Bhat",
                "description" => "Savory minced meat curry served over steamed rice with a rich egg yolk topping.",
                "price" => 220,
                "image" => asset('img/home/spicychicken.png'),
                "colspan" => 7
            ],
            [
                "id" => 3,
                "name" => "Corndog",
                "description" => "Crispy golden corndog with a juicy sausage and melted cheese center, perfect for a quick snack.",
                "price" => 120,
                "image" => asset('img/home/corndog.png'),
                "colspan" => 4
            ],
            [
                "id" => 4,
                "name" => "Keema Noodles",
                "description" => "Stir-fried noodles with minced meat and vegetables, seasoned to perfection.",
                "price" => 200,
                "image" => asset('img/home/keemanoodles.png'),
                "colspan" => 4
            ],
            [
                "id" => 5,
                "name" => "Sha Phaley",
                "description" => "Tibetan dish of bread stuffed with seasoned meat and cabbage",
                "price" => 100,
                "image" => asset('img/home/syafale.png'),
                "colspan" => 4
            ],
        ];
        return view('welcome', compact('popularItems'));
    }
}
