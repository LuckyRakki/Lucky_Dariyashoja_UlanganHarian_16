<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();

        return response()->json([
            'status' => 200,
            'message' => 'Review retrieved succesfully',
            'data' => $reviews,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000'
    ]);

        $reviews = Review::create($request->all());

        return response()->json([
            'status' => 201,
            'message' => 'Review created succesfully.',
            'data' => $reviews
        ], 201);
    }

  public function show($id)
{
    $reviews = Review::find($id);

    if (!$reviews) {
        return response()->json([
            'status' => 404,
            'message' => 'Review not found.',
            'data' => null,
        ], 404);
    }

    return response()->json([
        'status' => 200,
        'message' => 'Review retrieved successfully.',
        'data' => $reviews,
    ], 200);
}
public function update(Request $request, $id)
{
    $reviews = Review::find($id);

    if (!$reviews) {
        return response()->json([
            'status' => 404,
            'message' => 'Reviews not found.',
            'data' => null
        ], 404);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000'
    ]);
    $reviews->update($request->all());

    return response()->json([
        'status' => 200,
        'message' => 'Reviews updated successfully.',
        'data' => $reviews
    ], 200);
}
public function destroy($id)
{
    $reviews = Review::find($id);

    if (!$reviews) {
        return response()->json([
            'status' => 404,
            'message' => 'Reviews not found.',
            'data' => null
        ], 404);
    }

    $reviews->delete();

    return response()->json([
        'status' => 200,
        'message' => 'Review deleted successfully.',
        'data' => null
    ], 200);
}
}