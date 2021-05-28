<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::query()
            ->where('seller_id', auth('seller')->id())
            ->orderBy('id', 'DESC')
            ->paginate(25);

        return view('items.index', compact('items'));
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
        $item->seller_id = auth('seller')->id();
        $item->save();

        return redirect()->route('items-index')->with('success', 'Item added successfully!');
    }

    public function editItem($id)
    {
        $item = Item::where('id', $id)
            ->where('seller_id', auth('seller')->id())
            ->firstOrFail();

        return view('items.edit', [
            'item' => $item,
        ]);
    }

    public function updateItem($id, ItemUpdateRequest $request)
    {
        $item = Item::where('id', $id)
            ->where('seller_id', auth('seller')->id())
            ->firstOrFail();

        $item->title = $request->get('item_title');
        $item->price = $request->get('item_price');

        if ($request->hasFile('item_image')) {
            $item->image = $request->file('item_image')->store('', 'items');
        }

        $item->save();

        return back()->with('success', 'Item updated successfully!');
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

        $items = Item::query()
            ->where('seller_id', auth('seller')->id())
            ->get();

        /** @var Item $item */
        foreach ($items as $item) {
            fputcsv($handle, [
                $item->id,
                $item->title,
                $item->price,
                $item->created_at
            ]);
        }

        fclose($handle);
    }

    public function exportToExcel()
    {
        $data = [];

        $data[] = [
            'Id',
            'Title',
            'Price',
            'Created At'
        ];

        $items = Item::query()
            ->where('seller_id', auth('seller')->id())
            ->get();

        /** @var Item $item */
        foreach ($items as $item) {
            $data[] = [
                $item->id,
                $item->title,
                $item->price,
                $item->created_at
            ];
        }

        $spreadSheet = new Spreadsheet();
        $spreadSheet->getActiveSheet()->fromArray($data);

        $excel = new Xlsx($spreadSheet);

        $excel->save(storage_path('downloads/item_catalog' . time() . '.xlsx'));

        return back()->with('success', 'Your download is being prepared, we will notify you shortly');
    }
}
