<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        /** @var Builder $builder */
        $builder = Item::where('id', '>', 0);

        $items = $builder->orderBy('id', 'DESC')
            ->paginate(30);

        $categories = Category::all();

        return view('home.index', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }

    public function categoryItems($id, $slug)
    {
        /** @var Category $category */
        $category = Category::where('id', $id)->firstOrFail();

        $items = $category->items()->paginate(30);

        return view('home.category-items', [
            'items' => $items,
            'category' => $category,
        ]);
    }
}
