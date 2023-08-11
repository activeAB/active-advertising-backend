<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use App\Models\Order;
use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use Symfony\Component\HttpKernel\Event\ResponseEvent;
>>>>>>> abdi

class ProformaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $proforma = Proforma::all();
        return response()->json($proforma,200);
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

        // Validate the proforma data
        $validatedProformaData = $request->validate([
<<<<<<< HEAD
            "invoice_date" => 'required',
            "payment_request_number" => 'required',

            "active_tin_nUmber" => 'required',
            "active_account_number" => 'required',
            "active_vat" => 'required',
            "active_phone_number" => 'required',
            "active_email" => 'required',

            "client_name" => 'required',
            "client_tin_number" => 'required',
            "client_phone_number" => 'required',

            "price_validity" => 'required',
            "payment_method" => 'required',
            "contact_person" => 'required',
            "total_price" => 'required',
=======
            "invoice_date"=>'required',
            "payment_request_number"=>'required',
    
            "active_tin_nUmber"=>'required',
            "active_account_number"=>'required',
            "active_vat"=>'required',
            "active_phone_number"=>'required',
            "active_email"=>'required',
    
            "client_name"=>'required',
            "client_tin_number"=>'required',
            "client_phone_number"=>'required',
            
            "price_validity"=>'required',
            "payment_method"=>'required',
            "contact_person"=>'required',
            "total_price"=>'required',
>>>>>>> abdi
        ]);

        // Validate the order data (assuming you're sending an array of orders)
        $validatedOrderData = $request->validate([
            'orders' => 'required|array|min:1',
            'orders.*.item_description' => 'required',
            'orders.*.size' => 'required',
            'orders.*.quantity' => 'required',
            'orders.*.unit_price' => 'required',
            'orders.*.vendor_name' => 'required',
        ]);

        try {
            // Create the proforma
            $proforma = Proforma::create($validatedProformaData);

            // Create and associate orders with the proforma
            foreach ($validatedOrderData['orders'] as $orderData) {
                $order = new Order($orderData);
                $order->proforma()->associate($proforma);
                $order->save();
            }

<<<<<<< HEAD
            return response()->json(['message' => 'Data stored successfully'], 200);
=======
            return response()->json(['message' => 'Data stored successfully'],200);
>>>>>>> abdi
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while storing data'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
<<<<<<< HEAD
        $order = Order::where('proforma_id', $id)->get();
        return response()->json([
            'data' => $order,
=======
        $proforma = Proforma::where('id',$id)->get();
        $order = Order::where('proforma_id',$id)->get();
        return response()->json([
            'proforma' => $proforma,
            'order' => $order,
>>>>>>> abdi
        ], 200);
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
<<<<<<< HEAD
    }
}
=======
        $proforma = Proforma::findOrFail($id);
        $proforma->delete();
        return response()->json($proforma,200);
    }
}
>>>>>>> abdi
