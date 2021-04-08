<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function items()
    {

    }

    public function createItemForm()
    {
        return view('items.create');
    }

    public function createItem(CreateItemRequest $request)
    {
        $item = new Item();
        $item->title = $request->get('item_title');
        $item->price = $request->get('item_price');
        $item->image = $request->file('item_image')->store('', 'items');
        $item->save();

        return redirect()->route('home')->with('success', 'Item added successfullÿ!');
    }

    public function editItem($id)
    {
        $item = Item::where('id', $id)->firstOrFail();

        return view('items.edit', [
            'item' => $item,
        ]);
    }

    public function updateItem($id, ItemUpdateRequest $request)
    {
        $item = Item::where('id', $id)->firstOrFail();

        $item->title = $request->get('item_title');
        $item->price = $request->get('item_price');

        if ($request->hasFile('item_image')) {
            $item->image = $request->file('item_image')->store('', 'items');
        }

        $item->save();

        return redirect()->route('home')->with('success', 'Item updated successfully!');
    }

    public function exportToCsv()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=catalog_' . time() . '.csv');

        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'ID',
            'Item Title',
            'Item Prce',
            'Created At'
        ]);

        /** @var Item $item */
        foreach (Item::get() as $item) {
            fputcsv($handle, [
                $item->id,
                $item->title,
                $item->price,
                $item->created_at
            ]);
        }

        fclose($handle);
    }
}
