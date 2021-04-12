<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;

class HomeController extends Controller
{
    public function index()
    {
        $items = Item::where('id', '>', 0)
            ->orderBy('id', 'DESC')
            ->paginate(20);

        $categories = Category::all();

        return view('home.index', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }
}
