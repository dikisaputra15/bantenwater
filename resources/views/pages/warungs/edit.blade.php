@extends('layouts.app')

@section('title', 'Edit warung')

@push('style')

@endpush

@section('main')
<h1 class="h3 mb-2 text-gray-800">Form Edit Warung UMKM</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Warung UMKM</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('warung.update', $warung->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Warung UMKM</label>
                    <input type="text" class="form-control" name="nama_warung" value="{{ $warung->nama_warung }}">
                </div>
                <div class="form-group">
                    <label>Deskripsi Warung UMKM</label>
                    <input type="text" class="form-control" name="deskripsi_warung" value="{{ $warung->deskripsi_warung }}">
                </div>
                <div class="form-group">
                    <label>Gambar Warung</label>
                    <input type="file" class="form-control" name="gambar_warung">
                    <input type="text" class="form-control" name="old_file" value="{{ $warung->gambar_warung }}" hidden>
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
