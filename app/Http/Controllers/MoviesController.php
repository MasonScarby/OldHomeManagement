<?php

namespace App\Http\Controllers;

use App\Models\Movies;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    // Get all movies
    public function index()
    {
        $movies = movies::all();
        return response()->json(data: $movies);
    }

    // Get a single movie by ID
    public function show($id)
    {
        $movie = movies::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json($movie);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'required|date',
            'number_of_ratings' => 'required|integer|min:0',
            'average_rating' => 'required|numeric|min:0|max:10',
        ]);

        $movie = movies::create([
            'name' => $request->name,
            'director' => $request->director,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'number_of_ratings' => $request->number_of_ratings,
            'average_rating' => $request->average_rating,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Movie created successfully',
            'data' => $movie
        ], 201);
    }
    public function update(Request $request, $id)
{
    $movie = movies::find($id);

    if (!$movie) {
        return response()->json(['message' => 'Movie not found'], 404);
    }

    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'director' => 'sometimes|required|string|max:255',
        'description' => 'nullable|string',
        'release_date' => 'sometimes|required|date',
        'number_of_ratings' => 'sometimes|required|integer|min:0',
        'average_rating' => 'sometimes|required|numeric|min:0|max:10',
    ]);

    // Log the request data for debugging
    \Log::info($request->all());

    try {
        $movie->update($request->only(['name', 'director', 'description', 'release_date', 'number_of_ratings', 'average_rating']));
    } catch (\Exception $e) {
        return response()->json(['message' => 'Update failed', 'error' => $e->getMessage()], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Movie updated successfully',
        'data' => $movie
    ]);
}


    // Delete a movie
    public function destroy($id)
    {
        $movie = movies::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $movie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Movie deleted successfully'
        ], 200);
    }
}
