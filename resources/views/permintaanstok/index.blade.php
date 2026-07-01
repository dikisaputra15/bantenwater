@extends('layouts.app')

@section('title','Data Produk')

@section('main')

<div class="row">

<div class="col-md-12">

<h2 class="font-weight-bold">
Data Produk
</h2>

<h4 class="text-muted mb-4">
Dashboard / Data Produk
</h4>

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4 class="mb-0">

<i class="mdi mdi-bookmark-check"></i>

Verifikasi Stok

</h4>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered" id="dataTable">

<thead>

<tr>

<th width="60">No</th>

<th>Nama Produk</th>

<th>Stok Saat Ini</th>

<th>Permintaan Tambahan</th>

<th>Status</th>

<th width="220">Aksi</th>

</tr>

</thead>

<tbody>

@forelse($permintaan as $no=>$row)

<tr>

<td>{{ $no+1 }}</td>

<td>

<b>{{ $row->nama_produk }}</b>

</td>

<td>

{{ number_format($row->stock) }} Dus

</td>

<td>

<b>{{ number_format($row->qty) }} Dus</b>

</td>

<td>

@if($row->status=='menunggu')

<span class="badge badge-warning">

MENUNGGU

</span>

@elseif($row->status=='disetujui')

<span class="badge badge-success">

DISETUJUI

</span>

@else

<span class="badge badge-danger">

DITOLAK

</span>

@endif

</td>

<td>

@if($row->status=='menunggu')

<form
action="{{ route('permintaanstok.verifikasi',$row->id) }}"
method="POST"
style="display:inline">

@csrf

<button
class="btn btn-success">

Verifikasi

</button>

</form>

<form
action="{{ route('permintaanstok.tolak',$row->id) }}"
method="POST"
style="display:inline">

@csrf

<button
class="btn btn-danger">

Tolak

</button>

</form>

@else

-

@endif

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center">

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

</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
