<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Menampilkan daftar semua buku
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    // Menampilkan form tambah buku
    public function create()
    {
        return view('books.create');
    }

    // Menyimpan buku baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'publisher' => 'nullable|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|unique:books,isbn',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable'
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    // Menampilkan detail buku
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    // Menampilkan form edit buku
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // Update buku
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'publisher' => 'nullable|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|unique:books,isbn,' . $book->id,
            'stock' => 'required|integer|min:0',
            'description' => 'nullable'
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    // Hapus buku
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}