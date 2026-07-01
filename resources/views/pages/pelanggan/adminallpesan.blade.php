@extends('layouts.app')

@section('title', 'Users')

@push('style')
<style>

.filter-wrapper{
    position:relative;
}

.filter-box{
    display:none;
    position:absolute;
    top:65px;
    right:0;
    width:330px;
    background:#fff;
    border-radius:12px;
    padding:20px;
    z-index:999;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
}

.filter-box label{
    font-weight:600;
}

.filter-box .btn{
    border-radius:10px;
}

</style>
@endpush

@section('main')
<h1 class="h3 mb-2 text-gray-800">Data Pesanan</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Dashboard/Data Pesanan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

        <div class="row mb-4 align-items-center">

    <div class="col-md-8">

        <input
            type="text"
            id="searchBox"
            class="form-control form-control-lg"
            placeholder="Cari Pesanan...">

    </div>

    <div class="col-md-4">

        <div class="filter-wrapper">

            <button
                type="button"
                class="btn btn-primary btn-lg btn-block"
                id="btnFilter">

                <i class="mdi mdi-filter"></i>

                Filter

            </button>

            <div class="filter-box" id="filterMenu">

                <form method="GET">

                    <div class="form-group">

                        <label>Status Pesanan</label>

                        <select
                            name="status"
                            class="form-control">

                            <option value="">Semua Status</option>

                            <option value="dipesan"
                            {{ request('status')=='dipesan'?'selected':'' }}>
                                Dipesan
                            </option>

                            <option value="dikirim"
                            {{ request('status')=='dikirim'?'selected':'' }}>
                                Dikirim
                            </option>

                            <option value="dalam perjalanan"
                            {{ request('status')=='dalam perjalanan'?'selected':'' }}>
                                Dalam Perjalanan
                            </option>

                            <option value="selesai"
                            {{ request('status')=='selesai'?'selected':'' }}>
                                Selesai
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Tanggal</label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ request('tanggal') }}"
                            class="form-control">

                    </div>

                    <div class="text-right">

                        <a href="{{ url()->current() }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                        <button class="btn btn-primary">

                            Terapkan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

            <table class="table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i = 1)
                    @foreach ($pesanans as $pesan)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$pesan->name}}</td>
                        <td>{{$pesan->tgl_pemesanan}}</td>
                        <td>
                            <span class="badge badge-info">

                                {{ strtoupper($pesan->status_pesanan) }}

                            </span>
                        </td>
                        <td>

                            @if($pesan->status_pembayaran=='belum bayar')

                                <span class="badge badge-danger">

                                    BELUM BAYAR

                                </span>

                            @elseif($pesan->status_pembayaran=='menunggu verifikasi')

                                <span class="badge badge-warning">

                                    MENUNGGU VERIFIKASI

                                </span>

                            @else

                                <span class="badge badge-success">

                                    LUNAS

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

@endsection

@push('scripts')

<script>

$(document).ready(function(){

    let table;

    if($.fn.DataTable.isDataTable('#dataTable')){
        table = $('#dataTable').DataTable();
    }else{
        table = $('#dataTable').DataTable({
            ordering:false,
            pageLength:10,
            dom:'lrtip'
        });
    }

    $('#searchBox').keyup(function(){

        table.search($(this).val()).draw();

    });

    $('#btnFilter').click(function(e){

        e.stopPropagation();

        $('#filterMenu').toggle();

    });

    $(document).click(function(e){

        if(!$(e.target).closest('#filterMenu,#btnFilter').length){

            $('#filterMenu').hide();

        }

    });

});

</script>

@endpush
