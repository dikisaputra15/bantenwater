@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
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

            </div>
    </div>
</div>

@endsection

