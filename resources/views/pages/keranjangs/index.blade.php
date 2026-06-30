@extends('layouts.app')

@section('title','Keranjang Belanja')

@section('main')

<h1 class="h3 mb-4 text-gray-800">
    Semua Pesanan
</h1>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('cart.update') }}" method="POST">
    @csrf

    <div class="card shadow">

        <div class="card-body">

            @php
                $grandTotal = 0;
            @endphp

            @if(count($cart) > 0)

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th width="120">Harga</th>
                            <th width="120">Qty</th>
                            <th width="150">Subtotal</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($cart as $item)

                        @php
                            $subtotal = $item['harga'] * $item['stock'];
                            $grandTotal += $subtotal;
                        @endphp

                        <tr>

                            <td>
                                <div class="d-flex align-items-center">

                                    <img src="{{ Storage::url('gambarproduk/'.$item['gambar']) }}"
                                         width="70"
                                         class="mr-3">

                                    <strong>
                                        {{ $item['nama_produk'] }}
                                    </strong>

                                </div>
                            </td>

                            <td>
                                Rp {{ number_format($item['harga'],0,',','.') }}
                            </td>

                            <td>
                                <input type="number"
                                       name="stock[{{ $item['id'] }}]"
                                       value="{{ $item['stock'] }}"
                                       min="1"
                                       class="form-control">
                            </td>

                            <td>
                                Rp {{ number_format($subtotal,0,',','.') }}
                            </td>

                            <td>

                                <a href="{{ route('cart.remove',$item['id']) }}"
                                   class="btn btn-danger btn-sm">

                                    <i class="mdi mdi-delete"></i>

                                </a>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="text-right">

                <h4>
                    Total :
                    <span class="text-success">
                        Rp {{ number_format($grandTotal,0,',','.') }}
                    </span>
                </h4>

            </div>

            @else

            <div class="alert alert-warning">
                Keranjang masih kosong
            </div>

            @endif

        </div>

        @if(count($cart) > 0)

        <div class="card-footer d-flex justify-content-between">

            <button type="submit" class="btn btn-primary">
                Update Qty
            </button>

            <a href="{{ route('checkout') }}" class="btn btn-success">
                Order
            </a>

        </div>

        @endif

    </div>

</form>

@endsection
