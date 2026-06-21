@extends('layouts.app')

@section('title', 'Produk')

@push('style')

@endpush

@section('main')
<h1 class="h3 mb-2 text-gray-800">Form Tambah Produk</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Produk</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('produk.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="card-body">

                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" required>
                            </div>

                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" name="stock" required>
                            </div>

                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" class="form-control" name="harga" required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Produk</label>
                                <input type="text" class="form-control" name="deskripsi_produk" required>
                            </div>

                            <div class="form-group">
                                <label>Gambar</label>
                                <input type="file" class="form-control" name="gambar" required>
                            </div>

                <div class="form-group">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')

@endpush
