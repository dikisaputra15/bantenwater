@extends('layouts.app')

@section('title','Status Pemesanan')

@section('main')

<h3 class="font-weight-bold">

Status Pemesanan

</h3>

<div class="card shadow">

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover" id="dataTable">

<thead class="thead-light">

<tr>

<th>No</th>
<th>Kode Pesanan</th>
<th>Total</th>
<th>Status</th>
<th>Pembayaran</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($pesanans as $no=>$row)

<tr>

<td>{{ $no+1 }}</td>

<td>{{ $row->kode_pesanan }}</td>

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

Belum Bayar

</span>

@elseif($row->status_pembayaran=='menunggu verifikasi')

<span class="badge badge-warning">

Menunggu Verifikasi

</span>

@else

<span class="badge badge-success">

Lunas

</span>

@endif

</td>

<td>

<button
class="btn btn-primary btn-sm"
data-toggle="modal"
data-target="#status{{ $row->id }}">

Lihat Status

</button>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

@foreach($pesanans as $row)

<div class="modal fade"
     id="status{{ $row->id }}"
     tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    Status Pesanan
                </h5>

                <button type="button"
                        class="close text-white"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                @foreach($row->detail as $detail)

                <div class="card mb-4">

                    <div class="card-body">

                        <div class="row align-items-center">

                            <div class="col-md-3">

                                <img src="{{ Storage::url('gambarproduk/'.$detail->path_gambar) }}"
                                     width="180">

                            </div>

                            <div class="col-md-5">

                                <h4>{{ $detail->nama_produk }}</h4>

                                <h5>
                                    Rp {{ number_format($detail->harga,0,',','.') }}
                                    × {{ $detail->qty }}
                                </h5>

                            </div>

                            <div class="col-md-4 text-right">

                                <h5>Total Pembelian</h5>

                                <h3>
                                    Rp {{ number_format($row->total,0,',','.') }}
                                </h3>

                            </div>

                        </div>

                    </div>

                </div>

                @endforeach

                {{-- Progress Status di sini --}}

                <div class="my-5">

<div class="d-flex justify-content-between align-items-center">

<div class="text-center">

<i class="mdi mdi-package-variant
{{ in_array($row->status_pesanan,['dipesan','dikirim','dalam perjalanan','selesai'])?'text-primary':'text-muted' }}"
style="font-size:45px"></i>

<br>

Dipesan

</div>

<div style="flex:1;height:3px;background:#ddd"></div>

<div class="text-center">

<i class="mdi mdi-truck
{{ in_array($row->status_pesanan,['dikirim','dalam perjalanan','selesai'])?'text-primary':'text-muted' }}"
style="font-size:45px"></i>

<br>

Dikirim

</div>

<div style="flex:1;height:3px;background:#ddd"></div>

<div class="text-center">

<i class="mdi mdi-truck-fast
{{ in_array($row->status_pesanan,['dalam perjalanan','selesai'])?'text-primary':'text-muted' }}"
style="font-size:45px"></i>

<br>

Dalam Perjalanan

</div>

<div style="flex:1;height:3px;background:#ddd"></div>

<div class="text-center">

<i class="mdi mdi-check-circle
{{ $row->status_pesanan=='selesai'?'text-success':'text-muted' }}"
style="font-size:45px"></i>

<br>

Selesai

</div>

</div>

</div>

<div class="timeline mt-5">

<ul class="list-group">


@if(in_array($row->status_pesanan,['dikirim','dalam perjalanan','selesai']))

<li class="list-group-item">

Pesanan telah dikirim

</li>

@endif

@if(in_array($row->status_pesanan,['dalam perjalanan','selesai']))

<li class="list-group-item">

Pesanan sedang dalam perjalanan

</li>

@endif

@if($row->status_pesanan=="selesai")

<li class="list-group-item list-group-item-success">

Pesanan telah diterima

</li>

@endif

</ul>

</div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                    Tutup

                </button>

            </div>

        </div>

    </div>

</div>

@endforeach

@endsection

@push('scripts')
<script>
$(function () {
    $('#dataTable').DataTable();
});
</script>
@endpush
