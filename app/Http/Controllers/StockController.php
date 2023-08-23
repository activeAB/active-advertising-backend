<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stock = Stock::all();
        return response()->json(
            $stock,
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'item_description' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'total_price' => 'required',
            'unit_measurement' => 'required',
            'purchase_date' => 'required',
            'expire_date' => 'required',
            'dealer_name' => 'required',
        ]);

        $stock = Stock::create($data);
        return response()->json($stock, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->validate([
            'item_description' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'total_price' => 'required',
            'unit_measurement' => 'required',
            'purchase_date' => 'required',
            'expire_date' => 'required',
            'dealer_name' => 'required',
        ]);
        $stock = Stock::findOrFail($id);
        $stock->update($data);
        return response()->json($stock, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return response()->json([
            'data' => $stock,
        ], 200);
    }
}
