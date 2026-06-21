@extends('layouts.app')

@section('title','Proses Pembayaran')

@section('main')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Detail Pesanan
    </h1>

    <form id="checkoutForm">

        @csrf

        <div class="row">

            {{-- Detail Pesanan --}}
            <div class="col-md-8">

                <div class="card shadow mb-4">

                    <div class="card-header">
                        <strong>Pesanan Anda</strong>
                    </div>

                    <div class="card-body">

                        @php
                            $grandTotal = 0;
                        @endphp

                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th width="100">Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>

                                <tbody>

                                @foreach($cart as $item)

                                    @php
                                        $qty = $item['qty'] ?? $item['stock'] ?? 1;
                                        $subtotal = $item['harga'] * $qty;
                                        $grandTotal += $subtotal;
                                    @endphp

                                    <tr>

                                        <td>
                                            {{ $item['nama_produk'] }}
                                        </td>

                                        <td>
                                            Rp {{ number_format($item['harga'],0,',','.') }}
                                        </td>

                                        <td>
                                            {{ $qty }}
                                        </td>

                                        <td>
                                            Rp {{ number_format($subtotal,0,',','.') }}
                                        </td>

                                    </tr>

                                @endforeach

                                </tbody>

                                <tfoot>

                                    <tr>

                                        <th colspan="3" class="text-right">
                                            Total
                                        </th>

                                        <th class="text-success">
                                            Rp {{ number_format($grandTotal,0,',','.') }}
                                        </th>

                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Pembayaran --}}
            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-header">
                        <strong>Metode Pembayaran</strong>
                    </div>

                    <div class="card-body">

                        <div class="form-group">

                            <label>Nama Pembeli</label>

                            <input
                                type="text"
                                name="nama_pembeli"
                                class="form-control"
                                required>

                        </div>

                        <div class="form-group">

                            <label>No HP</label>

                            <input
                                type="text"
                                name="no_hp"
                                class="form-control"
                                required>

                        </div>

                        <div class="form-group">

                            <label>Pilih Pembayaran</label>

                            <div class="custom-control custom-radio mb-2">

                                <input
                                    type="radio"
                                    id="cash"
                                    name="metode_pembayaran"
                                    value="Cash"
                                    class="custom-control-input"
                                    checked>

                                <label class="custom-control-label" for="cash">
                                    Cash
                                </label>

                            </div>

                            <div class="custom-control custom-radio">

                                <input
                                    type="radio"
                                    id="qris"
                                    name="metode_pembayaran"
                                    value="QRIS"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="qris">
                                    QRIS / Transfer
                                </label>

                            </div>

                        </div>

                        <hr>

                        <h5>Total Bayar</h5>

                        <h3 class="text-success">
                            Rp {{ number_format($grandTotal,0,',','.') }}
                        </h3>

                        <button
                            type="button"
                            id="btnCheckout"
                            class="btn btn-success btn-block mt-3">

                            Konfirmasi Pembayaran

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script
src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>

$('#btnCheckout').click(function(){

    let nama = $('input[name="nama_pembeli"]').val();
    let nohp = $('input[name="no_hp"]').val();
    let metode = $('input[name="metode_pembayaran"]:checked').val();

    if(nama === ''){
        alert('Nama pembeli wajib diisi');
        return;
    }

    if(nohp === ''){
        alert('No HP wajib diisi');
        return;
    }

    $('#btnCheckout')
        .prop('disabled', true)
        .text('Memproses...');

    $.ajax({

        url: "{{ route('checkout.create-order') }}",

        type: "POST",

        data: {

            _token: "{{ csrf_token() }}",

            nama_pembeli: nama,

            no_hp: nohp,

            metode_pembayaran: metode

        },

        success: function(response){

            if(response.type === 'cash'){

                window.location.href = response.redirect;

            }

            if(response.type === 'qris'){

                snap.pay(response.snap_token, {

                    onSuccess: function(result){

                        window.location.href = "{{ route('allpesanan') }}";

                    },

                    onPending: function(result){

                        alert('Menunggu pembayaran');

                        window.location.href = "{{ route('allpesanan') }}";

                    },

                    onError: function(result){

                        alert('Pembayaran gagal');

                        window.location.href = "{{ route('allpesanan') }}";

                    },

                    onClose: function(){

                        window.location.href = "{{ route('allpesanan') }}";

                    }

                });

            }

        },

        error: function(xhr){

            console.log(xhr.responseText);

            alert(
                xhr.responseJSON?.message ??
                'Terjadi kesalahan pada server'
            );

            $('#btnCheckout')
                .prop('disabled', false)
                .text('Konfirmasi Pembayaran');

        }

    });

});

</script>

@endpush
