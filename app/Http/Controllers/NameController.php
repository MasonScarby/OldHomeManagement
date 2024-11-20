<?php

namespace App\Http\Controllers;

use App\Models\name;
use Illuminate\Http\Request;

class NameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $names = name::all();
        return response()->json([
            'success' => true,
            'data' => $names
        ]);
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
            $names= name::create([
            'name' => $request->name,
            'type' => $request->type,
        
        ]);

            return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $names
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(name $name)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(name $name)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, name $name)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(name $name)
    {
        // Delete the specified name record
        // $name->delete();
    
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Deleted successfully'

        // ], 200);
    }
    
}
