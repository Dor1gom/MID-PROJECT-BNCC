<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Member;
use App\Models\Book;
use App\Models\BorrowingDetail;
use App\Models\BorrowingDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $borrowings = Borrowing::with(['member', 'details.book'])
            ->latest()
            ->paginate(10);
        
        return view('borrowings.index', compact('borrowings'));
    }

    // Form tambah peminjaman
    public function create()
    {
        $members = Member::where('status', 'active')->get();
        $books = Book::where('stock', '>', 0)->get();
        
        return view('borrowings.create', compact('members', 'books'));
    }

    // Simpan peminjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
            'books' => 'required|array|min:1',
            'books.*' => 'exists:books,id',
            'quantities.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Buat peminjaman
            $borrowing = Borrowing::create([
                'member_id' => $request->member_id,
                'borrow_date' => $request->borrow_date,
                'due_date' => $request->due_date,
                'status' => 'borrowed',
                'notes' => $request->notes
            ]);

            // Tambah detail buku yang dipinjam
            foreach ($request->books as $index => $bookId) {
                $book = Book::find($bookId);
                $quantity = $request->quantities[$index];

                // Cek stok
                if ($book->stock < $quantity) {
                    throw new \Exception("Stok buku {$book->title} tidak mencukupi");
                }

                // Simpan detail
                BorrowingDetails::create([
                    'borrowing_id' => $borrowing->id,
                    'book_id' => $bookId,
                    'quantity' => $quantity,
                    'condition_borrowed' => $request->conditions[$index] ?? 'good'
                ]);

                // Kurangi stok
                $book->decrement('stock', $quantity);
            }

            DB::commit();

            return redirect()->route('borrowings.show', $borrowing)
                ->with('success', 'Peminjaman berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Detail peminjaman
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['member', 'details.book']);
        return view('borrowings.show', compact('borrowing'));
    }

    // Form edit peminjaman
    public function edit(Borrowing $borrowing)
    {
        $members = Member::where('status', 'active')->get();
        $books = Book::all();
        $borrowing->load(['details.book']);
        
        return view('borrowings.edit', compact('borrowing', 'members', 'books'));
    }

    // Update peminjaman
    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
        ]);

        $borrowing->update($request->only(['member_id', 'borrow_date', 'due_date', 'notes']));

        return redirect()->route('borrowings.show', $borrowing)
            ->with('success', 'Peminjaman berhasil diupdate!');
    }

    // Proses pengembalian
    public function return(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'return_date' => 'required|date',
            'conditions' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            // Update status peminjaman
            $borrowing->update([
                'return_date' => $request->return_date,
                'status' => 'returned'
            ]);

            // Update kondisi buku dan kembalikan stok
            foreach ($borrowing->details as $detail) {
                $detail->update([
                    'condition_returned' => $request->conditions[$detail->id] ?? 'good'
                ]);

                // Kembalikan stok
                $detail->book->increment('stock', $detail->quantity);
            }

            DB::commit();

            return redirect()->route('borrowings.show', $borrowing)
                ->with('success', 'Buku berhasil dikembalikan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Hapus peminjaman
    public function destroy(Borrowing $borrowing)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok jika belum dikembalikan
            if ($borrowing->status == 'borrowed') {
                foreach ($borrowing->details as $detail) {
                    $detail->book->increment('stock', $detail->quantity);
                }
            }

            $borrowing->delete();
            DB::commit();

            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}