<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => 200,
            'message' => 'User retrieved succesfully',
            'data' => $users,
        ], 200);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:15',
        ]);

        // Membuat pengguna baru
        $users = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password), // Enkripsi password
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json($users, 201);
    }

    public function show($id)
    {
        $users = User::find($id);

    if (!$users) {
        return response()->json([
            'status' => 404,
            'message' => 'User not found.',
            'data' => null,
        ], 404);
    }

    return response()->json([
        'status' => 200,
        'message' => 'User retrieved successfully.',
        'data' => $users,
    ], 200);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $id,
            'password' => 'sometimes|required|string|min:6',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:15',
        ]);

        // Mengambil pengguna berdasarkan ID
        $users = User::findOrFail($id);

        // Memperbarui pengguna
        $users->update($request->only(['username', 'name', 'email', 'phone']));

        // Jika password diupdate, enkripsi password
        if ($request->filled('password')) {
            $users->password = bcrypt($request->password);
            $users->save();
        }

        return response()->json($users);
    }

    public function destroy($id)
    {
        $users = User::find($id);

    if (!$users) {
        return response()->json([
            'status' => 404,
            'message' => 'User not found.',
            'data' => null
        ], 404);
    }

    $users->delete();

    return response()->json([
        'status' => 200,
        'message' => 'User deleted successfully.',
        'data' => null
    ], 200);
    }
}