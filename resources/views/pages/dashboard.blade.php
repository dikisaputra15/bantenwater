@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<style>
.product-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    background:#fff5f5;
    transition:.3s;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    height:100%;
}

.product-card:hover{
    transform:translateY(-8px);
}

.product-card img{
    height:280px;
    width:100%;
    object-fit:cover;
}

.product-body{
    padding:20px;
}

.product-title{
    font-size:28px;
    font-weight:700;
}

.product-price{
    font-size:28px;
    font-weight:bold;
    color:#111;
    margin-top:20px;
}

.rating{
    text-align:center;
    margin-top:60px;
}

.rating i{
    color:#ff9800;
    font-size:32px;
    margin:0 2px;
}

.product-footer{
    border-top:5px solid #222;
}

.btn-cart{
    border-radius:30px;
}

.dashboard-card{

border-radius:18px;
color:white;
overflow:hidden;

}

.dashboard-card .top{

padding:18px;

display:flex;

justify-content:space-between;

align-items:center;

}

.dashboard-card .bottom{

padding:15px;

font-size:36px;

font-weight:bold;

text-align:center;

}

.green{

background:#2f9d44;

}

.blue{

background:#4b5fd8;

}

.orange{

background:#f57c00;

}

.red{

background:#d62828;

}

.menu-box{

background:#efefef;

padding:20px;

text-align:center;

border-radius:10px;

transition:.3s;

}

.menu-box:hover{

transform:translateY(-5px);

}

.menu-box i{

font-size:70px;

margin-bottom:10px;

}

</style>
@endpush

@section('main')

<div class="row">
    <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Dashboard</h3>
                </div>

                @if(auth()->user()->roles=='pelanggan')

<div class="row">

@forelse($produks as $produk)

<div class="col-lg-6 mb-3">

    <div class="card product-card">

        @if($produk->path_gambar)

        <img src="{{ Storage::url('gambarproduk/'.$produk->path_gambar) }}">

        @else

        <img src="https://via.placeholder.com/600x400">

        @endif

        <div class="product-footer"></div>

        <div class="product-body">

            <h5 class="product-title">
                {{ strtoupper($produk->nama_produk) }}
            </h5>

            <div class="product-price">
                Rp. {{ number_format($produk->harga,0,',','.') }}
            </div>

            <div class="rating text-center mt-4">

                <i class="mdi mdi-star"></i>
                <i class="mdi mdi-star"></i>
                <i class="mdi mdi-star"></i>
                <i class="mdi mdi-star"></i>
                <i class="mdi mdi-star"></i>

            </div>

        </div>

    </div>

</div>

@empty

<div class="col-12">

    <div class="alert alert-warning">

        Belum ada produk.

    </div>

</div>

@endforelse

</div>

@endif

 @if(auth()->user()->roles=='admin')

    <div class="row mb-4">

<div class="col-md-3">

<div class="dashboard-card green">

<div class="top">

<h5>Total Pemesanan</h5>

<i class="mdi mdi-clipboard-text mdi-36px"></i>

</div>

<div class="bottom" style="font-size:20px;">

{{ number_format($totalPesanan) }} Pesanan

</div>

</div>

</div>

<div class="col-md-3">

<div class="dashboard-card blue">

<div class="top">

<h5>Total Pelanggan</h5>

<i class="mdi mdi-account-group mdi-36px"></i>

</div>

<div class="bottom" style="font-size:20px;">

{{ number_format($totalPelanggan) }} Pelanggan

</div>

</div>

</div>

<div class="col-md-3">

<div class="dashboard-card orange">

<div class="top">

<h5>Stok Produk</h5>

<i class="mdi mdi-package-variant mdi-36px"></i>

</div>

<div class="bottom" style="font-size:20px;">

{{ number_format($stokProduk) }} Dus

</div>

</div>

</div>

<div class="col-md-3">

<div class="dashboard-card red">

<div class="top">

<h5>Menunggu Pembayaran</h5>

<i class="mdi mdi-calendar-clock mdi-36px"></i>

</div>

<div class="bottom" style="font-size:20px;">

{{ number_format($menungguPembayaran) }} Transaksi

</div>

</div>

</div>

</div>

<div class="row mt-4">

    <div class="col-lg-8 mb-4">

        <div class="card shadow h-100">

            <div class="card-header">
                <h4>Daftar Pesanan Terbaru</h4>
            </div>

            <div class="card-body">

                <table class="table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($pesananTerbaru as $no=>$row)

                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->kode_pesanan }}</td>
                        <td>Rp {{ number_format($row->total,0,',','.') }}</td>
                        <td>{{ ucfirst($row->status_pesanan) }}</td>
                    </tr>

                    @endforeach

                    </tbody>

                </table>
                <p><a href="{{ route('pesanan.status') }}">Lihat Semua ></a></p>
            </div>

        </div>

    </div>

    <div class="col-lg-4 mb-4">

        <div class="card shadow h-100">

            <div class="card-header">
                <h4>Laporan Penjualan Bulanan</h4>
            </div>

            <div class="card-body">

                <canvas id="chartPenjualan"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="row mt-5">

<div class="col-md-6">

<div class="card">

<div class="card-header">

<h4>Data Pelanggan</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-6">

<a href="{{ Route('user.index') }}">

<div class="menu-box">

<i class="mdi mdi-account-search"></i>

<h5>Lihat Data</h5>

</div>

</a>

</div>

<div class="col-6">

<a href="{{ route('user.create') }}">

<div class="menu-box">

<i class="mdi mdi-account-plus"></i>

<h5>Tambah Pelanggan</h5>

</div>

</a>

</div>

</div>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card">

<div class="card-header">

<h4>Manajemen Produk</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-6">

<a href="{{ route('produk.index') }}">

<div class="menu-box">

<i class="mdi mdi-package-variant"></i>

<h5>Lihat Stok</h5>

</div>

</a>

</div>

<div class="col-6">

<a href="{{ route('produk.create') }}">

<div class="menu-box">

<i class="mdi mdi-plus-box"></i>

<h5>Tambah Produk</h5>

</div>

</a>

</div>

</div>

</div>

</div>

</div>

</div>

 @endif

 @if(auth()->user()->roles=='pimpinan')

<div class="row">

    <div class="col-lg-12 mb-4">

        <div class="card shadow">

            <div class="card-header">

                <h4>Grafik Penjualan Tahun {{ date('Y') }}</h4>

            </div>

            <div class="card-body">

                <canvas id="chartPimpinan"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-12">

        <div class="card shadow">

            <div class="card-header bg-success text-white">

                <h4>

                    <i class="mdi mdi-clipboard-check"></i>

                    Verifikasi Stok

                </h4>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Permintaan</th>
                            <th>Status</th>
                            <th width="220">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($permintaan as $no=>$row)

                        <tr>

                            <td>{{ $no+1 }}</td>

                            <td>{{ $row->nama_produk }}</td>

                            <td>{{ number_format($row->qty) }} Dus</td>

                            <td>

                                @if($row->status=='menunggu')

                                    <span class="badge badge-warning">

                                        Menunggu

                                    </span>

                                @elseif($row->status=='disetujui')

                                    <span class="badge badge-success">

                                        Disetujui

                                    </span>

                                @else

                                    <span class="badge badge-danger">

                                        Ditolak

                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($row->status=='menunggu')

                                <a
                                    href="{{ route('permintaanstok.verifikasi',$row->id) }}"
                                    class="btn btn-success btn-sm">

                                    Verifikasi

                                </a>

                                <a
                                    href="{{ route('permintaanstok.tolak',$row->id) }}"
                                    class="btn btn-danger btn-sm">

                                    Tolak

                                </a>

                                @else

                                <span class="text-muted">

                                    Sudah diproses

                                </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                Tidak ada permintaan stok.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endif

 @if(auth()->user()->roles=='kurir')

    <div class="row mb-4">

<div class="col-md-4">

<div class="dashboard-card blue">

<div class="top">

<h5>Pesanan Baru</h5>

<i class="mdi mdi-clipboard-text mdi-36px"></i>

</div>

<div class="bottom">

{{ $pesananBaru }}

</div>

</div>

</div>

<div class="col-md-4">

<div class="dashboard-card red">

<div class="top">

<h5>Dalam Perjalanan</h5>

<i class="mdi mdi-truck-fast mdi-36px"></i>

</div>

<div class="bottom">

{{ $dalamPerjalanan }}

</div>

</div>

</div>

<div class="col-md-4">

<div class="dashboard-card green">

<div class="top">

<h5>Selesai</h5>

<i class="mdi mdi-check-circle mdi-36px"></i>

</div>

<div class="bottom">

{{ $selesai }}

</div>

</div>

</div>

</div>

<div class="row">

<div class="col-lg-8">

<div class="card shadow">

<div class="card-header">

<h4>Daftar Pengantaran</h4>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-striped table-bordered table-hover w-100">

<thead>

<tr>

<th>No</th>

<th>Nama</th>

<th>Kode</th>

<th>Total</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($pesanan as $no=>$row)

<tr>

<td>{{ $no+1 }}</td>

<td>{{ $row->name }}</td>

<td>{{ $row->kode_pesanan }}</td>

<td>

Rp {{ number_format($row->total) }}

</td>

<td>

@if($row->status_pesanan=='dikirim')

<span class="badge badge-primary">

DIKIRIM

</span>

@elseif($row->status_pesanan=='dalam perjalanan')

<span class="badge badge-warning">

DALAM PERJALANAN

</span>

@else

<span class="badge badge-success">

SELESAI

</span>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card shadow">

<div class="card-header">

<h4>Tugas Pengantaran</h4>

</div>

<div class="card-body">

@if($tugas)

<h5>

{{ $tugas->name }}

</h5>

<p>

{{ $tugas->alamat_lengkap }}

</p>

<p>

{{ $tugas->no_hp }}

</p>

<div id="map"

style="height:300px;">

</div>

<br>

@if($tugas->status_pesanan=='dikirim')

<a
href="{{ route('kurir.mulai',$tugas->id) }}"
class="btn btn-success btn-block">

Mulai Antar

</a>

@elseif($tugas->status_pesanan=='dalam perjalanan')

<a
href="{{ route('kurir.selesai',$tugas->id) }}"
class="btn btn-primary btn-block">

Selesaikan Pengiriman

</a>

@endif

@else

<div class="alert alert-info">

Tidak ada tugas.

</div>

@endif

</div>

</div>

</div>

</div>

 @endif

            </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var map=L.map('map').setView([-6.12,106.15],13);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

L.marker([-6.12,106.15]).addTo(map)
.bindPopup("Lokasi Pengiriman");

</script>

@if(auth()->user()->roles=='admin')

<script>

new Chart(document.getElementById('chartPenjualan'),{

type:'bar',

data:{

labels:[
'Jan','Feb','Mar','Apr','Mei','Jun',
'Jul','Ags','Sep','Okt','Nov','Des'
],

datasets:[{

label:'Penjualan',

data:[
@for($i=1;$i<=12;$i++)
{{ $chart[$i]??0 }},
@endfor
],

backgroundColor:'#4b82d9'

}]

}

});

</script>

@endif


@if(auth()->user()->roles=='pimpinan')

<script>

new Chart(document.getElementById('chartPimpinan'),{

type:'bar',

data:{

labels:[
'Jan','Feb','Mar','Apr','Mei','Jun',
'Jul','Ags','Sep','Okt','Nov','Des'
],

datasets:[{

label:'Penjualan',

data:[
@for($i=1;$i<=12;$i++)
{{ $chart[$i]??0 }},
@endfor
],

backgroundColor:'#4b5fd8'

}]

}

});

</script>

@endif

@endpush
