<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<style>

body{

    font-family: DejaVu Sans;

    font-size:12px;

}

table{

    width:100%;

    border-collapse:collapse;

}

table th{

    background:#ececec;

}

table th,
table td{

    border:1px solid #000;

    padding:8px;

}

.title{

    text-align:center;

    margin-bottom:20px;

}

.text-right{

    text-align:right;

}

</style>

</head>

<body>

<div class="title">

<h2>

LAPORAN PENJUALAN

</h2>

<p>

Periode

{{ DateTime::createFromFormat('!m',$bulan)->format('F') }}

{{ $tahun }}

</p>

</div>

<table>

<thead>

<tr>

<th>No</th>

<th>Tanggal</th>

<th>Nama Pelanggan</th>

<th>Produk</th>

<th>Jumlah</th>

<th>Harga</th>

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

Rp {{ number_format($row->harga,0,',','.') }}

</td>

<td>

Rp {{ number_format($row->total,0,',','.') }}

</td>

<td>

{{ strtoupper($row->status_pesanan) }}

</td>

</tr>

@endforeach

</tbody>

<tfoot>

<tr>

<th colspan="6">

TOTAL PENJUALAN

</th>

<th colspan="2">

Rp {{ number_format($total,0,',','.') }}

</th>

</tr>

</tfoot>

</table>

</body>

</html>
