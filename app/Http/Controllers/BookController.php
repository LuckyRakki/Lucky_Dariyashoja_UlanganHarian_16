<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json([
            'status' => 200,
            'message' => 'Books retrieved succesfully',
            'data' => $books,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|string|max:255',

        ]);

        $books = Book::create($request->all());
        
        return response()->json([
            'status' => 201,
            'message' => 'Book created succesfully.',
            'data' => $books
        ], 201);
    }

    public function show($id)
    {
        $books = Book::findOrFail($id);

        if (!$books) {
            return response()->json([
                'status' => 404,
                'message' => 'Book not found.',
                'data' => null,
            ], 404);
        }
    
        return response()->json([
            'status' => 200,
            'message' => 'Book retrieved successfully.',
            'data' => $books,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $books = Book::findOrFail($id);

        if (!$books) {
            return response()->json([
                'status' => 404,
                'message' => 'Book not found.',
                'data' => null
            ], 404);
        }
    
        $request->validate([
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|string|max:255',                      
        ]);
        $books->update($request->all());
    
        return response()->json([
            'status' => 200,
            'message' => 'Book updated successfully.',
            'data' => $books
        ], 200);
    }

    public function destroy($id)
    {
        $books = Book::findOrFail($id);

        if (!$books) {
            return response()->json([
                'status' => 404,
                'message' => 'Book not found.',
                'data' => null
            ], 404);
        }
    
        $books->delete();
    
        return response()->json([
            'status' => 200,
            'message' => 'Book deleted successfully.',
            'data' => null
        ], 200);
    }
}