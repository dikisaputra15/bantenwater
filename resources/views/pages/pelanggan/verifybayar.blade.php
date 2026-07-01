@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')

@endpush

@section('main')

<div class="row">
    <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Pembayaran</h3>
                  <p>Dashboard/Pembayaran</p>
                </div>

                @if($pesanans->count())

<div class="card shadow mt-5">

    <div class="card-header bg-primary text-white">

        <h4 class="mb-0">
            Data Pembayaran
        </h4>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover" id="dataTable">

                <thead class="thead-light">

                    <tr>

                        <th>No</th>
                        <th>Kode Pesanan</th>
                        <th>Total</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                        <th>Bukti Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($pesanans as $key => $row)

                    <tr>

                        <td>{{ $key+1 }}</td>

                        <td>
                            <a href="#"
                            data-toggle="modal"
                            data-target="#detailPesanan{{ $row->id }}">

                                {{ $row->kode_pesanan }}

                            </a>
                        </td>

                        <td>
                            Rp {{ number_format($row->total,0,',','.') }}
                        </td>

                        <td>

                            <span class="badge badge-info">

                                {{ strtoupper($row->status_pesanan) }}

                            </span>

                        </td>

                        <td>

                            @if($row->status_pembayaran=='belum bayar')

                                <span class="badge badge-danger">

                                    BELUM BAYAR

                                </span>

                            @elseif($row->status_pembayaran=='menunggu verifikasi')

                                <span class="badge badge-warning">

                                    MENUNGGU VERIFIKASI

                                </span>

                            @else

                                <span class="badge badge-success">

                                    LUNAS

                                </span>

                            @endif

                        </td>

                        <td>
                            <a href="#" data-toggle="modal" data-target="#foto{{ $row->id }}">
                                <img
                                    src="{{ Storage::url('bukti_pembayaran/'.$row->bukti_pembayaran) }}"
                                    width="120"
                                    class="img-thumbnail"
                                    style="cursor:pointer;">
                            </a>
                        </td>

                        <td>
                            {{ $row->tgl_pemesanan }}
                        </td>

                        <td>
                            @if($row->status_pembayaran != 'lunas')
                                <a href="{{ route('pembayaran.verifikasi',$row->id) }}"
                                class="btn btn-success btn-sm"
                                onclick="return confirm('Verifikasi pembayaran ini?')">
                                    Verifikasi
                                </a>
                            @else
                                <span class="badge badge-success">
                                    Sudah Lunas
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

@endif

            </div>
    </div>
</div>

@foreach($pesanans as $row)
<div class="modal fade"
     id="detailPesanan{{ $row->id }}"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">

                    Detail Pesanan
                    <br>
                    <small>{{ $row->kode_pesanan }}</small>

                </h5>

                <button
                    class="close text-white"
                    data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <table class="table table-bordered">

                    <thead class="thead-light">

                        <tr>

                            <th width="80">Foto</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>

                        </tr>

                    </thead>

                    <tbody>

                        @php
                            $grandTotal = 0;
                        @endphp

                        @foreach($row->detail as $detail)

                        @php
                            $grandTotal += $detail->sub_total;
                        @endphp

                        <tr>

                            <td>

                                <img
                                    src="{{ Storage::url('gambarproduk/'.$detail->path_gambar) }}"
                                    width="70"
                                    class="img-thumbnail">

                            </td>

                            <td>

                                {{ $detail->nama_produk }}

                            </td>

                            <td>

                                Rp {{ number_format($detail->harga,0,',','.') }}

                            </td>

                            <td>

                                {{ $detail->qty }}

                            </td>

                            <td>

                                Rp {{ number_format($detail->sub_total,0,',','.') }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                    <tfoot>

                        <tr>

                            <th colspan="4" class="text-right">

                                Grand Total

                            </th>

                            <th>

                                Rp {{ number_format($grandTotal,0,',','.') }}

                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-secondary"
                    data-dismiss="modal">

                    Tutup

                </button>

            </div>

        </div>

    </div>

</div>
@endforeach

@foreach($pesanans as $row)

@if(empty($row->bukti_pembayaran))

<div class="modal fade"
     id="upload{{ $row->id }}"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form action="{{ route('pesanan.upload', $row->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">
                        Upload Bukti Pembayaran
                    </h5>

                    <button type="button"
                            class="close text-white"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="text-center mb-4">

                        <h5>{{ $row->kode_pesanan }}</h5>

                        <h4 class="text-success">
                            Rp {{ number_format($row->total,0,',','.') }}
                        </h4>

                    </div>

                    <div class="form-group">

                        <label>
                            Bukti Pembayaran
                        </label>

                        <input type="file"
                               name="bukti"
                               class="form-control"
                               accept="image/*"
                               required>

                        <small class="text-muted">
                            Format: JPG, JPEG atau PNG.
                        </small>

                    </div>

                    <div class="alert alert-info mb-0">

                        <strong>Petunjuk:</strong><br>

                        • Transfer sesuai nominal pesanan.<br>
                        • Upload foto/screenshot bukti transfer yang jelas.

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-success">

                        <i class="mdi mdi-upload"></i>

                        Upload Bukti

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endif

@endforeach

@foreach($pesanans as $row)

<div class="modal fade" id="foto{{ $row->id }}" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Bukti Pembayaran
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body text-center">

                <img
                    src="{{ Storage::url('bukti_pembayaran/'.$row->bukti_pembayaran) }}"
                    class="img-fluid rounded">

            </div>

        </div>

    </div>

</div>

@endforeach

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
