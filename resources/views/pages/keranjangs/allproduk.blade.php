@extends('layouts.app')

@section('title', 'Create Penjualan')

@push('style')
<style>
.rating i{
    color:#ff9800;
    font-size:32px;
    margin:0 2px;
}
</style>
@endpush

@section('main')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<h1 class="h3 mb-4 text-gray-800">Produk</h1>
<p>Dashboard/Produk</p>

<div class="row">

    @forelse($produks as $produk)
        <div class="col-xl-12 col-md-4 col-sm-6 mb-4">
            <div class="card shadow h-100">
                <div class="row">
                <div class="col-md-6">
                    @if($produk->path_gambar)
                    <img src="{{ Storage::url('gambarproduk/'.$produk->path_gambar) }}"
                        class="card-img-top"
                        style="height:300px;">
                    @else
                        <img src="https://via.placeholder.com/300x220?text=Kelapa"
                            class="card-img-top"
                            style="height:300px;">
                    @endif
                </div>

                <div class="col-md-6">
                    <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        {{ $produk->nama_produk }}
                    </h5>

                    <h4 class="text-success font-weight-bold">
                        Rp {{ number_format($produk->harga,0,',','.') }}
                    </h4>

                    <div class="rating text-center mt-4">

                        <i class="mdi mdi-star"></i>
                        <i class="mdi mdi-star"></i>
                        <i class="mdi mdi-star"></i>
                        <i class="mdi mdi-star"></i>
                        <i class="mdi mdi-star"></i>

                    </div>

                </div>

                <div class="card-footer bg-white">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf

                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                        <div class="input-group">
                                <button type="submit"
                                        class="btn btn-primary">
                                    Tambah
                                </button>
                        </div>
                    </form>
                </div>
                </div>


                </div>

            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning">
                Belum ada produk tersedia.
            </div>
        </div>
    @endforelse

</div>

@endsection

@push('scripts')

@endpush
