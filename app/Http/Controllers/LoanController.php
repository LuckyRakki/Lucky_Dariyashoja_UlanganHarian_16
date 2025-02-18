<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    // Menampilkan semua data pinjaman
    public function index()
    {
        $loans = Loan::with(['books', 'users'])->get(); // Mengambil semua data dengan relasi
        return response()->json([
            'status' => 200,
            'message' => 'Loans retrieved successfully.',
            'data' => $loans
        ]);
    }

    // Menyimpan data pinjaman baru
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'book_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
            'status' => 'required|string|max:255'
        ]);

        // Simpan data pinjaman baru
        $loan = Loan::create($request->all());

        return response()->json([
            'status' => 201,
            'message' => 'Loan created successfully.',
            'data' => $loan
        ], 201);
    }

    // Menampilkan detail pinjaman berdasarkan ID
    public function show($id)
    {
        $loan = Loan::with(['books', 'users'])->find($id);

        if (!$loan) {
            return response()->json([
                'status' => 404,
                'message' => 'Loan not found.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Loan retrieved successfully.',
            'data' => $loan
        ]);
    }

    // Memperbarui data pinjaman berdasarkan ID
    public function update(Request $request, $id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'status' => 404,
                'message' => 'Loan not found.',
                'data' => null
            ], 404);
        }

        // Validasi request
        $request->validate([
            'book_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
            'status' => 'required|string|max:255'
        ]);

        // Update data pinjaman
        $loan->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Loan updated successfully.',
            'data' => $loan
        ]);
    }

    // Menghapus data pinjaman berdasarkan ID
    public function destroy($id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'status' => 404,
                'message' => 'Loan not found.',
                'data' => null
            ], 404);
        }

        $loan->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Loan deleted successfully.',
            'data' => null
        ]);
    }
}