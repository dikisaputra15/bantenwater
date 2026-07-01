@extends('layouts.app')

@section('title','Daftar Pengantaran')

@section('main')

<h3 class="font-weight-bold mb-4">

Daftar Pengantaran

</h3>

<div class="card shadow">

<div class="card-header bg-primary text-white">

<div class="row">

<div class="col-md-6">

<h4 class="mb-0">

<i class="mdi mdi-truck-delivery"></i>

Data Pengantaran

</h4>

</div>

<div class="col-md-6">

<input
type="text"
id="search"
class="form-control"
placeholder="Cari Pengiriman...">

</div>

</div>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover" id="dataTable">

<thead class="thead-light">

<tr>

<th>No</th>

<th>Kode</th>

<th>Pelanggan</th>

<th>Tanggal</th>

<th>Total</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($pengantaran as $no=>$row)

<tr>

<td>{{ $no+1 }}</td>

<td>{{ $row->kode_pesanan }}</td>

<td>{{ $row->name }}</td>

<td>{{ $row->tgl_pemesanan }}</td>

<td>

Rp {{ number_format($row->total,0,',','.') }}

</td>

<td>

@if($row->status_pesanan=='dikirim')

<span class="badge badge-primary">

Dikirim

</span>

@elseif($row->status_pesanan=='dalam perjalanan')

<span class="badge badge-warning">

Dalam Perjalanan

</span>

@else

<span class="badge badge-success">

Selesai

</span>

@endif

</td>

<td>

<a
href="{{ route('pengantaran.show',$row->id) }}"
class="btn btn-info btn-sm">

<i class="mdi mdi-eye"></i>

Detail

</a>

@if($row->status_pesanan=='dikirim')

<a
href="{{ route('kurir.mulai',$row->id) }}"
class="btn btn-success btn-sm">

<i class="mdi mdi-truck-fast"></i>

Mulai

</a>

@endif

@if($row->status_pesanan=='dalam perjalanan')

<a
href="{{ route('kurir.selesai',$row->id) }}"
class="btn btn-primary btn-sm">

<i class="mdi mdi-check"></i>

Selesai

</a>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

@endsection

@push('scripts')

<script>

$(function(){

let table=$("#dataTable").DataTable({

responsive:true,

pageLength:10,

autoWidth:false,

dom:'lrtip'

});

$("#search").keyup(function(){

table.search($(this).val()).draw();

});

});

</script>

@endpush
