<?php

namespace App\Http\Controllers;
use App\Models\Freelancer;
use Illuminate\Http\Request;

class FreelancerConroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $freelancer = Freelancer::all();
        return $freelancer;
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
            'freelancer_first_name'=>'required',
            'freelancer_last_name'=>'required',
            'freelancer_address'=>'required',
            'freelancer_phone_number'=>'required',
            'freelancer_email'=>'required',
            'freelancer_image_url'=>'required',
            'freelancer_portfolio_link'=>'required',
            'freelancer_order_status'=>'required',
        ]);
        $freelancer = Freelancer::create($data);
        return $freelancer;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $freelancer = Freelancer::findOrFail($id);
        return $freelancer;
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
            'freelancer_first_name'=>'required',
            'freelancer_last_name'=>'required',
            'freelancer_address'=>'required',
            'freelancer_phone_number'=>'required',
            'freelancer_email',
            'freelancer_image_url'=>'required',
            'freelancer_portfolio_link'=>'required',
            'freelancer_order_status'=>'required',
        ]);

        $freelancer = Freelancer::findOrFail($id);
        $freelancer->update($data);
        return $freelancer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $freelancer = Freelancer::findOrFail($id);
        $freelancer->delete();
        return $freelancer;
    }
}
