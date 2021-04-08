<?php

namespace App\Http\Controllers;

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
            ->paginate(18);

        return view('home.index', [
            'items' => $items,
        ]);
    }
}
