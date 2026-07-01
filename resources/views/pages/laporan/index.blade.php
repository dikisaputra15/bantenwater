@extends('layouts.app')

@section('title', 'Laporan')

@section('main')
<h1 class="h3 mb-2 text-gray-800">Laporan</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Penjualan</h6>
        <p>Dashboard / Laporan Penjualan</p>
    </div>
    <div class="card-body">

        <div class="card shadow mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-3">

<select name="bulan" class="form-control">

@for($i=1;$i<=12;$i++)

<option

value="{{ $i }}"

{{ request('bulan',date('m'))==$i?'selected':'' }}

>

{{ DateTime::createFromFormat('!m',$i)->format('F') }}

</option>

@endfor

</select>

</div>

<div class="col-md-3">

<select name="produk" class="form-control">

<option value="">

Semua Produk

</option>

@foreach($produk as $p)

<option

value="{{ $p->id }}"

{{ request('produk')==$p->id?'selected':'' }}

>

{{ $p->nama_produk }}

</option>

@endforeach

</select>

</div>

<div class="col-md-3">

<select

name="status"

class="form-control">

<option value="">

Semua Status

</option>

<option value="dipesan">

Dipesan

</option>

<option value="dikirim">

Dikirim

</option>

<option value="dalam perjalanan">

Dalam Perjalanan

</option>

<option value="selesai">

Selesai

</option>

</select>

</div>

<div class="col-md-3">

<button class="btn btn-primary btn-block">

<i class="mdi mdi-filter"></i>

Filter

</button>

<a

href="{{ route('laporan.pdf',request()->all()) }}" target="_blank"

class="btn btn-success btn-block mt-2">

Download PDF

</a>

    <a href="{{ route('laporan.print',request()->all()) }}"
       target="_blank"
       class="btn btn-success btn-block mt-2">

        <i class="mdi mdi-printer"></i>

        Cetak

    </a>


</div>

</div>

</form>

</div>

</div>

<div class="card shadow mb-4">

<div class="card-header">

<h4>

Grafik Penjualan

</h4>

</div>

<div class="card-body">

<canvas id="chartPenjualan"></canvas>

</div>

</div>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered" id="dataTable">

<thead>

<tr>

<th>No</th>

<th>Tanggal</th>

<th>Nama Pelanggan</th>

<th>Produk</th>

<th>Jumlah</th>

<th>Total Harga</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@php($no=1)

@foreach($laporan as $row)

<tr>

<td>{{ $no++ }}</td>

<td>{{ date('d M Y',strtotime($row->tgl_pemesanan)) }}</td>

<td>{{ $row->name }}</td>

<td>{{ $row->nama_produk }}</td>

<td>{{ $row->qty }}</td>

<td>

Rp {{ number_format($row->total,0,',','.') }}

</td>

<td>

<span class="badge badge-success">

{{ ucfirst($row->status_pesanan) }}

</span>

</td>

</tr>

@endforeach

</tbody>

<tfoot>

<tr>

<th colspan="5">

Total Penjualan

</th>

<th colspan="2">

Rp {{ number_format($laporan->sum('total'),0,',','.') }}

</th>

</tr>

</tfoot>

</table>

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('chartPenjualan'),{

type:'bar',

data:{

labels:[
1,2,3,4,5,6,7,8,9,10,
11,12,13,14,15,16,17,18,19,20,
21,22,23,24,25,26,27,28,29,30,31
],

datasets:[{

label:'Penjualan',

data:@json($chart),

backgroundColor:'#4f6bdc'

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

}

}

});

</script>
@endpush
