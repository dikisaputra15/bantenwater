@extends('layouts.app')

@section('title', 'Invoice')

@section('main')

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-body">

            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="font-weight-bold">
                        INVOICE
                    </h2>

                    <p class="mb-1">
                        <strong>No Pesanan :</strong>
                        {{ $pesanan->kode_pesanan }}
                    </p>

                    <p class="mb-1">
                        <strong>Tanggal :</strong>
                        {{ $pesanan->tgl_pemesanan }}
                    </p>
                </div>

                <div class="col-md-6 text-right">
                    <h5>Data Pembeli</h5>

                    <p class="mb-1">
                        {{ $pesanan->nama_pembeli }}
                    </p>

                    <p class="mb-1">
                        Metode Pembayaran :
                        {{ $pesanan->metode_pembayaran }}
                    </p>

                    <p class="mb-1">
                        Status :
                        <span class="badge badge-success">
                            {{ $pesanan->status_pembayaran }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">

                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Produk</th>
                            <th width="15%">Harga</th>
                            <th width="10%">Qty</th>
                            <th width="20%">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $grandTotal = 0;
                        @endphp

                        @foreach($detailPesanan as $detail)

                        @php
                            $grandTotal += $detail->subtotal;
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $detail->nama_produk }}</td>

                            <td>
                                Rp {{ number_format($detail->harga,0,',','.') }}
                            </td>

                            <td>{{ $detail->qty }}</td>

                            <td>
                                Rp {{ number_format($detail->subtotal,0,',','.') }}
                            </td>
                        </tr>

                        @endforeach

                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th>
                                Rp {{ number_format($pesanan->total_harga,0,',','.') }}
                            </th>
                        </tr>
                    </tfoot>

                </table>
            </div>

            <div class="mt-4">
                <button onclick="window.print()"
                    class="btn btn-primary">
                    <i class="fas fa-print"></i>
                    Cetak Invoice
                </button>

                <a href="{{ url('/allpesanan') }}"
                    class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </div>
    </div>

</div>

@endsection
