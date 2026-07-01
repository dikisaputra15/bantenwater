@extends('layouts.app')

@section('title','Permohonan Penambahan Stok')

@section('main')

<div class="row justify-content-center">

<div class="col-md-7">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>

<i class="mdi mdi-send"></i>

Permohonan Penambahan Stok

</h4>

</div>

<div class="card-body">

<form
action="{{ route('permintaanstok.store') }}"
method="POST">

@csrf

<input
type="hidden"
name="produk_id"
value="{{ $produk->id }}">

<div class="form-group">

<label>Nama Produk</label>

<input
type="text"
class="form-control"
value="{{ $produk->nama_produk }}"
readonly>

</div>

<div class="form-group">

<label>Stok Saat Ini</label>

<input
type="text"
class="form-control"
value="{{ number_format($produk->stock) }} Dus"
readonly>

</div>

<div class="form-group">

<label>Jumlah Permintaan</label>

<input
type="number"
name="qty"
class="form-control"
placeholder="Masukkan jumlah stok yang diminta"
required>

</div>

<div class="form-group">

<label>Alasan Penambahan</label>

<textarea
name="keterangan"
class="form-control"
rows="4"
placeholder="Contoh: Stok hampir habis karena permintaan pelanggan meningkat"></textarea>

</div>

<div class="text-right">

<a href="{{ route('produk.index') }}"
class="btn btn-secondary">

Kembali

</a>

<button
class="btn btn-success">

<i class="mdi mdi-send"></i>

Kirim ke Pimpinan

</button>

</div>

</form>

</div>

</div>

</div>

</div>

@endsection
