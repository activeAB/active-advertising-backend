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

        return[
            'user'=>$user,
            'freelancer'=>$freelancer
        ];
    }

    public function staffList(string $user_role){
        $users = User::where('user_role', $user_role);
        return $users;
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
        $order = Order::where('id',$id)->get();
        return $order;
    }

    public function employeeOrder($user_role,$id){
        if($user_role==="freelancer"){
            $orders = Order::where('freelancer_id', $id)->get();
            return $orders;
        }
        $orders = Order::where('user_id',$id)->get();
        return $orders;
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
}
