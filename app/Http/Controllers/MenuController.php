<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Display the menu page.
     */
    public function index(): View
    {
        // Load categories with their items, ordered as needed
        $categories = ItemCategory::with(['items' => function($query) {
            $query->orderBy('name');
        }])->orderBy('name')->get();

        return view('menu', compact('categories'));
    }
}