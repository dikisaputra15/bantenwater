@extends('layouts.app')

@section('title', 'All Penjualan')

@section('main')
<h1 class="h3 mb-2 text-gray-800">All Penjualan</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ url('/penjualan/create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Tambah Penjualan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Nama Pembeli</th>
                        <th>Total Harga</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i = 1)
                    @foreach ($pesanans as $pesanan)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$pesanan->tgl_pemesanan}}</td>
                        <td>{{$pesanan->nama_pembeli}}</td>
                        <td>{{$pesanan->total_harga}}</td>
                        <td>{{$pesanan->metode_pembayaran}}</td>
                        <td>{{$pesanan->status_pembayaran}}</td>
                        <td>
                            @if($pesanan->status_pembayaran == 'Paid')
                                <a href="{{ url('/pembayaran/'.$pesanan->id.'/invoice') }}"
                                    class="btn btn-primary btn-sm">
                                    Invoice
                                </a>
                            @else
                                <button
                                    class="btn btn-success btn-sm btn-bayar"
                                    data-token="{{ $pesanan->snap_token }}">
                                    Bayar
                                </button>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>

<script src="{{ config('midtrans.snap_url') }}"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
$(document).on('click','.btn-bayar',function(){

    let snapToken = $(this).data('token');

    snap.pay(snapToken, {

        onSuccess: function(result){

            Swal.fire({
                icon:'success',
                title:'Pembayaran Berhasil'
            }).then(() => {
                location.reload();
            });
        },

        onPending: function(result){

            Swal.fire({
                icon:'info',
                title:'Menunggu Pembayaran'
            });
        },

        onError: function(result){

            Swal.fire({
                icon:'error',
                title:'Pembayaran Gagal'
            });
        }
    });

});
</script>

@endpush
