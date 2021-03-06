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

    public function categoryItems($id)
    {
        /** @var Category $model */
        $model = Category::query()->where('id', $id)->firstOrFail();

        $items = $model->items()->paginate(25);

        return view('home.category-items', compact('model', 'items'));
    }
}
