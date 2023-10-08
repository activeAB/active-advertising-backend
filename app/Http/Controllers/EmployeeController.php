<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use function Laravel\Prompts\select;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rolesToExclude = ['admin', 'account_manager'];
        $user = User::whereNotIn('user_role', $rolesToExclude)->get();

        $freelancer = Freelancer::all();
        $data =  array_merge($user->toArray(), $freelancer->toArray());

        return response()->json(
            $data,
            200
        );
    }

    public function staffList(string $user_role)
    {
        if ($user_role == "all") {
            $users = User::where('delete_role', 'no')->get();
            return response()->json(
                $users,
                200
            );
        }
        $users = User::where('user_role', $user_role)->where('delete_role', 'no')->get();
        return response()->json(
            $users,
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $order = Order::where('id', $id)->get();
        return response()->json([
            'data' => $order,
        ], 200);
    }

    public function employeeAllOrder($user_role, $id)
    {
        if ($user_role === "freelancer") {
            $orders = Order::where('freelancer_id', $id)->get();
            return response()->json([
                'data' => $orders,
            ], 200);
        }
        $orders = Order::where('user_id', $id)->get();
        return response()->json([
            'data' => $orders,
        ], 200);
    }

    public function employeeOrder($user_role, $id)
    {


        if ($user_role === "freelancer") {
            $orders = Order::where('freelancer_id', $id)->where(function ($query) {
                $query->where('status', 'Allocated')
                    ->orWhere('status', 'Done');
            })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'data' => $orders,
            ], 200);
        }
        $orders = Order::where('user_id', $id)
            ->where(function ($query) {
                $query->where('status', 'Allocated')
                    ->orWhere('status', 'Done');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($orders as $item) {
            $item->formatted_created_at = date('Y-m-d', strtotime($item->created_at));
        }

        return response()->json([
            'data' => $orders,
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
    }

    public function employeeListStaff()
    {
        $users = User::all();
        foreach ($users as $user) {
            $allocated = false;
            $orders = Order::where('user_id', $user->id)->get();

            foreach ($orders as $order) {
                if (($order->status !== 'Done') and ($order->status !== 'Cancelled')) {
                    $allocated = true;
                    break;
                }
            }

            if ($allocated) {
                // Update user status to "allocated"
                $user->status = 'Allocated';
                $user->save();
            } else {
                // Update user status to "unallocated"
                $user->status = 'Unallocated';
                $user->save();
            }
        }
        $rolesToExclude = ['admin', 'account-manager'];
        $user = User::whereNotIn('user_role', $rolesToExclude)->where('delete_role', 'no')->get();
        // $data =  array_merge($user->toArray());

        return response()->json(
            $user,
            200
        );
    }
    public function employeeListFreelancer()
    {
        $freelancers = Freelancer::where('delete_role', 'no')->get;
        foreach ($freelancers as $freelancer) {
            $allocated = false;
            $orders = Order::where('freelancer_id', $freelancer->id)->get();

            foreach ($orders as $order) {
                if (($order->status !== 'Done') and ($order->status !== 'Cancelled')) {
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

        return response()->json(
            $freelancers,
            200
        );
    }
}
