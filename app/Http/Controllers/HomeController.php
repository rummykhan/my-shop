<?php

namespace App\Http\Controllers;

use App\Models\Item;

class HomeController extends Controller
{
    public function index()
    {
        $items = Item::where('id', '>', 0)
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('home.index', [
            'items' => $items,
        ]);
    }
}
