<?php

namespace App\Http\Controllers;

use App\Models\Basic_info;
use Illuminate\Http\Request;

class Basic_infoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $basic_info = Basic_info::all();
        return $basic_info;
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
        $validateBasicInfo = $request->validate([
            "active_tin_nUmber" => 'required',
            "active_account_number" => 'required',
            "active_vat" => 'required',
            "active_phone_number" => 'required',
            "active_email" => 'required',
        ]);

        $basic_info = Basic_info::where('id', $id)->first();
        $basic_info->update($validateBasicInfo);
        return $basic_info;
    }

    
    public function destroy(string $id)
    {
        //
    }
}
