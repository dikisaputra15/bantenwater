@extends('layouts.app')

@section('title','Detail Pengantaran')

@section('main')

<h3 class="font-weight-bold mb-4">
Detail Pengantaran
</h3>

<div class="row">

<div class="col-lg-8">

<div class="card shadow mb-4">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">
Informasi Pelanggan
</h5>

</div>

<div class="card-body">

<table class="table table-borderless">

<tr>
<td width="180">Nama</td>
<td>: {{ $pesanan->name }}</td>
</tr>

<tr>
<td>No HP</td>
<td>: {{ $pesanan->no_hp }}</td>
</tr>

<tr>
<td>Email</td>
<td>: {{ $pesanan->email }}</td>
</tr>

<tr>
<td>Alamat</td>
<td>: {{ $pesanan->alamat_lengkap }}</td>
</tr>

<tr>
<td>Kode Pesanan</td>
<td>: {{ $pesanan->kode_pesanan }}</td>
</tr>

<tr>
<td>Total</td>
<td>

Rp {{ number_format($pesanan->total,0,',','.') }}

</td>

</tr>

</table>

</div>

</div>


<div class="card shadow">

<div class="card-header bg-success text-white">

<h5 class="mb-0">

Produk Pesanan

</h5>

</div>

<div class="card-body">

@foreach($detail as $item)

<div class="row mb-3">

<div class="col-md-2">

@if($item->path_gambar)

<img
src="{{ Storage::url('gambarproduk/'.$item->path_gambar) }}"
class="img-fluid rounded">

@endif

</div>

<div class="col-md-6">

<h5>

{{ $item->nama_produk }}

</h5>

Jumlah :
{{ $item->qty }}

</div>

<div class="col-md-4 text-right">

Rp

{{ number_format($item->harga,0,',','.') }}

</div>

</div>

<hr>

@endforeach

</div>

</div>

</div>



<div class="col-lg-4">

<div class="card shadow">

<div class="card-header bg-info text-white">

<h5 class="mb-0">

Lokasi Pengiriman

</h5>

</div>

<div class="card-body">

<div id="map"
style="height:300px;"></div>

<hr>

<h6>Status</h6>

<span class="badge badge-primary">

{{ strtoupper($pesanan->status_pesanan) }}

</span>

<br><br>

@if($pesanan->status_pesanan=='dikirim')

<form
method="POST"
action="{{ route('kurir.mulai',$pesanan->id) }}">

@csrf

<button
class="btn btn-warning btn-block">

Mulai Antar

</button>

</form>

@endif


@if($pesanan->status_pesanan=='dalam perjalanan')

<form
method="POST"
action="{{ route('kurir.selesai',$pesanan->id) }}">

@csrf

<button
class="btn btn-success btn-block">

Pesanan Sampai

</button>

</form>

@endif

</div>

</div>

</div>

</div>

@endsection


@push('scripts')

<link
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var map=L.map('map').setView([-6.12,106.15],13);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

L.marker([-6.12,106.15]).addTo(map)
.bindPopup("Lokasi Pengiriman");

</script>

@endpush
