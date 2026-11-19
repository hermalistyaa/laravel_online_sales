
@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')

<div class="page-header">
    <h1>Manajemen Kategori</h1>
    <p>Kelola kategori produk Ruang Belanja.</p>
</div>

<div class="card">
    <h3>Tambah Kategori</h3>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <input
            type="text"
            name="name"
            placeholder="Masukkan nama kategori"
            required
        >

        <button type="submit">Tambah Kategori</button>
    </form>
</div>

<div class="card">
    <h3>Daftar Kategori</h3>

    @forelse ($categories as $category)
        <div>
            <strong>{{ $category->name }}</strong>
            <span>{{ $category->products_count }} produk</span>

            <form action="{{ route('admin.categories.destroy', $category) }}"
                  method="POST">
                @csrf
                @method('DELETE')

                <button type="submit">Hapus</button>
            </form>
        </div>
    @empty
        <p>Belum ada kategori.</p>
    @endforelse
</div>

@endsection
