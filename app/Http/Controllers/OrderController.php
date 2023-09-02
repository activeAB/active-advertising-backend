<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\Order;
use App\Models\User;
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
    public function updateStaff(Request $request, string $id)
    {
        
        $order = Order::findOrFail($id);

        $data = $request->validate([
            'status' => 'required',
            'user_id' => 'sometimes|nullable|exists:users,id', // Validate if user_id exists in the 'users' table
        ]);

        $order->update([
            'status' => $data['status'],
        ]);

        // Update the relationship between the order and the user (if 'user_id' is provided)
        
        // if (isset($data['user_id'])) {
        //     // Attach the order to the specified user
        //     $order->user()->associate(User::findOrFail($data['user_id']));
        //     $order->save();
        // }

        // Check if 'user_id' is not null, then update the relationship between the order and the user
        if (!is_null($data['user_id'])) {
            // Attach the order to the specified user
            $order->user()->associate(User::findOrFail($data['user_id']));
            $order->save();
        } else {
            // If 'user_id' is null, you can disassociate the order from any user
            $order->user()->dissociate();
            $order->save();
        }

        // Check if the status is 'Allocated' and update the user
        if ($data['status'] === 'Allocated') {
            // Assuming there's a 'user_id' field in the order model
            $user_id = $order->user_id;

            // Fetch the user by user_id or return a 404 error if not found
            $user = User::findOrFail($user_id);

            // Update the user (you should adjust this part as needed)
            $user->update([
                'status' => 'Allocated', // You may need to modify this based on your User model
            ]);
        }

        // Return a JSON response with the updated order
        return response()->json($order, 200);
    }

    public function updateFreelancer(Request $request, string $id){

        $order = Order::findOrFail($id);

        $data = $request->validate([
            'status' => 'required',
            'freelancer_id'=> 'sometimes|nullable|exists:freelancers,id', // Validate if user_id exists in the 'users' table
        ]);

        $order->update([
            'status' => $data['status'],
        ]);

        // Check if 'user_id' is not null, then update the relationship between the order and the user
        if (!is_null($data['freelancer_id'])) {
            // Attach the order to the specified user
            $order->freelancer()->associate(Freelancer::findOrFail($data['freelancer_id']));
            $order->save();
        } else {
            // If 'user_id' is null, you can disassociate the order from any user
            $order->freelancer()->dissociate();
            $order->save();
        }

        // Check if the status is 'Allocated' and update the freelancer
        if ($data['status'] === 'Allocated') {
            // Assuming there's a 'freelancer_id' field in the order model
            $freelancer_id = $order->freelancer_id;

            // Fetch the user by freelancer_id or return a 404 error if not found
            $freelancer = Freelancer::findOrFail($freelancer_id);

            // Update the freelancer (you should adjust this part as needed)
            $freelancer->update([
                'status' => 'Allocated', // You may need to modify this based on your Freelancer model
            ]);
        }

        // Return a JSON response with the updated order
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

    public function employer(string $id){
        // $order = Order::where('id', $id)->get();
        $order = Order::find($id);
        $freelancer = $order->freelancer_id;
        $user= $order->user_id;
        

        if ($user != "Unallocated"){
            $users = User::where('id', $user)->get();
            return response()->json($users, 200);
        }
        if ($freelancer != "Unallocated"){
            $freelancers = Freelancer::where('id', $freelancer)->get();
            return response()->json($freelancers,200);
        }
    }
}
