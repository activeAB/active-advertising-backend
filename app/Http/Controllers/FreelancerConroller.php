<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use Illuminate\Http\Request;
use App\Models\Order;

class FreelancerConroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $freelancer = Freelancer::orderBy('created_at', 'desc')->get();
        return response()->json(
            $freelancer,
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
            'freelancer_first_name' => 'required',
            'freelancer_last_name' => 'required',
            'freelancer_address' => 'required',
            'freelancer_phone_number' => 'required',
            'freelancer_email' => 'required',
            'freelancer_image_url' => 'required',
            'freelancer_portfolio_link' => 'required',
        
        ]);
        $checkUser =  $user = Freelancer::where('freelancer_email', $data['freelancer_email'])->first();
        if ($checkUser) {
            return response()->json(['message' => 'user exist'], 401);
        }
        $freelancer = Freelancer::create($data);
        return response()->json([
            'data' => $freelancer,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $freelancers = Freelancer::all();
        foreach ($freelancers as $freelancer) {
            $allocated = false;
            $orders = Order::where('freelancer_id', $freelancer->id)->get();

            foreach ($orders as $order) {
                if ($order->status === 'Allocated') {
                    $allocated = true;
                    break;
                }
            }

            if ($allocated) {
                // Update user status to "allocated"
                $freelancer->status = 'Allocated';
                $freelancer->save();
            } else {
                // Update user status to "unallocated"
                $freelancer->status = 'Unallocated';
                $freelancer->save();
            }
        }


        $freelancer = Freelancer::findOrFail($id);
        return response()->json([
            'data' => $freelancer,
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
        $data = $request->validate([
            'freelancer_first_name' => 'required',
            'freelancer_last_name' => 'required',
            'freelancer_address' => 'required',
            'freelancer_phone_number' => 'required',
            'freelancer_email',
            'freelancer_image_url' => 'required',
            'freelancer_portfolio_link' => 'required',
            'freelancer_order_status' => 'required',
        ]);

        $freelancer = Freelancer::findOrFail($id);
        $freelancer->update($data);
        return response()->json([
            'data' => $freelancer,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $freelancer = Freelancer::findOrFail($id);
        $freelancer->delete();
        return response()->json([
            'data' => $freelancer,
        ], 200);
    }
}
