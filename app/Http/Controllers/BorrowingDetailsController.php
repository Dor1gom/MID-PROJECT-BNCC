<?php

namespace App\Http\Controllers;

use App\Models\BorrowingDetail;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingDetailController extends Controller
{
    // Tambah buku ke peminjaman yang sudah ada
    public function store(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'condition_borrowed' => 'required|in:good,fair,damaged'
        ]);

        $book = Book::find($request->book_id);

        // Cek stok
        if ($book->stock < $request->quantity) {
            return back()->with('error', 'Stok buku tidak mencukupi');
        }

        DB::beginTransaction();
        try {
            // Tambah detail
            BorrowingDetail::create([
                'borrowing_id' => $borrowing->id,
                'book_id' => $request->book_id,
                'quantity' => $request->quantity,
                'condition_borrowed' => $request->condition_borrowed,
                'notes' => $request->notes
            ]);

            // Kurangi stok
            $book->decrement('stock', $request->quantity);

            DB::commit();

            return back()->with('success', 'Buku berhasil ditambahkan ke peminjaman!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Update detail buku
    public function update(Request $request, BorrowingDetail $detail)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'condition_borrowed' => 'required|in:good,fair,damaged'
        ]);

        $oldQuantity = $detail->quantity;
        $newQuantity = $request->quantity;
        $difference = $newQuantity - $oldQuantity;

        $book = $detail->book;

        // Cek stok jika menambah quantity
        if ($difference > 0 && $book->stock < $difference) {
            return back()->with('error', 'Stok buku tidak mencukupi');
        }

        DB::beginTransaction();
        try {
            // Update detail
            $detail->update([
                'quantity' => $newQuantity,
                'condition_borrowed' => $request->condition_borrowed,
                'notes' => $request->notes
            ]);

            // Adjust stok
            if ($difference > 0) {
                $book->decrement('stock', $difference);
            } elseif ($difference < 0) {
                $book->increment('stock', abs($difference));
            }

            DB::commit();

            return back()->with('success', 'Detail peminjaman berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Hapus buku dari peminjaman
    public function destroy(BorrowingDetail $detail)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok jika belum dikembalikan
            if ($detail->borrowing->status == 'borrowed') {
                $detail->book->increment('stock', $detail->quantity);
            }

            $detail->delete();
            DB::commit();

            return back()->with('success', 'Buku berhasil dihapus dari peminjaman!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}