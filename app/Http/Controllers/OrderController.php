<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::orderBy('created_at', 'desc')->get();
        foreach ($order as $item) {
            $item->formatted_created_at = date('Y-m-d', strtotime($item->created_at));
        }
        return response()->json($order, 200);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $order = Order::where('id', $id)->get();
        return response()->json($order, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
            'status' => 'required',
        ]);

        $order = Order::findOrFail($id);
        $order->update($data);

        return response()->json($order, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json($order, 200);
    }
}
