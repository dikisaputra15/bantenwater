@extends('layouts.app')

@section('title', 'Create Penjualan')

@section('main')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<h1 class="h3 mb-4 text-gray-800">Aneka Macam Kelapa Kelapa</h1>

<div class="row">

    @forelse($produks as $produk)
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card shadow h-100">

                @if($produk->path_gambar)
                    <img src="{{ Storage::url('gambarproduk/'.$produk->path_gambar) }}"
                        class="card-img-top"
                        style="height:220px; object-fit:cover;">
                @else
                    <img src="https://via.placeholder.com/300x220?text=Kelapa"
                         class="card-img-top"
                         style="height:220px; object-fit:cover;">
                @endif

                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        {{ $produk->nama_produk }}
                    </h5>

                    <p class="text-muted mb-2">
                        {{ $produk->deskripsi_produk }}
                    </p>

                    <h4 class="text-success font-weight-bold">
                        Rp {{ number_format($produk->harga,0,',','.') }}
                    </h4>

                    <p class="mb-2">
                        Stock :
                        <span class="badge badge-info">
                            {{ $produk->stock }}
                        </span>
                    </p>
                </div>

                <div class="card-footer bg-white">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf

                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                        <div class="input-group">
                            <div class="input-group-append">
                                <button type="submit"
                                        class="btn btn-success">
                                    <i class="fas fa-cart-plus"></i>
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning">
                Belum ada produk kelapa tersedia.
            </div>
        </div>
    @endforelse

</div>

@endsection

@push('scripts')

@endpush
