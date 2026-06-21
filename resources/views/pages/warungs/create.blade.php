@extends('layouts.app')

@section('title', 'warung')

@push('style')

@endpush

@section('main')
<h1 class="h3 mb-2 text-gray-800">Form Tambah Warung UMKM</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Warung UMKM</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('warung.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Warung UMKM</label>
                    <input type="text" class="form-control" name="nama_warung" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi Warung</label>
                    <input type="text" class="form-control" name="deskripsi_warung" required>
                </div>

                <div class="form-group">
                    <label>Gambar Warung</label>
                    <input type="file" class="form-control" name="gambar_warung" required>
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
