<!DOCTYPE html>
<html>

<head>

<title>Cetak Laporan</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>

body{

padding:30px;

font-size:14px;

}

table{

width:100%;

}

th{

background:#f1f1f1;

}

@media print{

button{

display:none;

}

}

</style>

</head>

<body>

<div class="text-center mb-4">

<h2>

LAPORAN PENJUALAN

</h2>

<h5>

Periode

{{ DateTime::createFromFormat('!m',$bulan)->format('F') }}

{{ $tahun }}

</h5>

</div>

<div class="text-right mb-3">

<button
onclick="window.print()"
class="btn btn-success">

🖨 Cetak

</button>

</div>

<table class="table table-bordered">

<thead>

<tr>

<th>No</th>

<th>Tanggal</th>

<th>Pelanggan</th>

<th>Produk</th>

<th>Qty</th>

<th>Total</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@php($no=1)

@foreach($laporan as $row)

<tr>

<td>{{ $no++ }}</td>

<td>{{ date('d-m-Y',strtotime($row->tgl_pemesanan)) }}</td>

<td>{{ $row->name }}</td>

<td>{{ $row->nama_produk }}</td>

<td>{{ $row->qty }}</td>

<td>

Rp {{ number_format($row->total,0,',','.') }}

</td>

<td>

{{ ucfirst($row->status_pesanan) }}

</td>

</tr>

@endforeach

</tbody>

<tfoot>

<tr>

<th colspan="5">

TOTAL PENJUALAN

</th>

<th colspan="2">

Rp {{ number_format($laporan->sum('total'),0,',','.') }}

</th>

</tr>

</tfoot>

</table>

<script>

window.onload=function(){

window.print();

}

</script>

</body>

</html>
