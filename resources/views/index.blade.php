@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Buku</h2>
    <a href="{{ route('books.create') }}" class="btn btn-primary">Tambah Buku Baru</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $index => $book)
                    <tr>
                        <td>{{ $books->firstItem() + $index }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher ?? '-' }}</td>
                        <td>{{ $book->publication_year ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $book->stock > 0 ? 'success' : 'danger' }}">
                                {{ $book->stock }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data buku</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection