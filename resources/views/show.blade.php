@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Edit Buku: {{ $book->title }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('books.update', $book) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                            id="title" name="title" value="{{ old('title', $book->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Penulis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror" 
                            id="author" name="author" value="{{ old('author', $book->author) }}" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="publisher" class="form-label">Penerbit</label>
                        <input type="text" class="form-control @error('publisher') is-invalid @enderror" 
                            id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}">
                        @error('publisher')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="publication_year" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control @error('publication_year') is-invalid @enderror" 
                                id="publication_year" name="publication_year" 
                                value="{{ old('publication_year', $book->publication_year) }}" 
                                min="1900" max="{{ date('Y') }}">
                            @error('publication_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                            id="stock" name="stock" value="{{ old('stock', $book->stock) }}" min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                            id="description" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection