<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate(40);

        return view('item.index', [
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateItemRequest $request)
    {
        $item = new Item();
        $item->title = $request->get('item_title');
        $item->price = $request->get('item_price');
        $item->image = $request->file('item_image')->store('', 'items');
        $item->save();

        return redirect()->route('item.index')->with('success', 'Item added successfullÿ!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('item.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $item->title = $request->get('item_title');
        $item->price = $request->get('item_price');

        if ($request->hasFile('item_image')) {
            $item->image = $request->file('item_image')->store('', 'items');
        }

        $item->save();

        return back()->with('success', 'Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
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

    public function exportToExcel()
    {
        $data = [];

        $data[] = [
            'Id',
            'Title',
            'Price',
            'Created At'
        ];

        /** @var Item $item */
        foreach (Item::get() as $item) {
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
