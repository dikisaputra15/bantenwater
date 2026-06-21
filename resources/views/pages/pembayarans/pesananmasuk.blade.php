@extends('layouts.app')

@section('title', 'Pesanan Masuk')

@section('main')
<h1 class="h3 mb-2 text-gray-800">Pesanan Masuk</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pesanan Masuk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Nomor Meja</th>
                        <th>Nama Pemesan</th>
                        <th>Jumlah</th>
                        <th>Harga Bayar</th>
                        <th>Subtotal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i = 1)
                    @foreach ($pesanans as $pesanan)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$pesanan->tgl_pemesanan}}</td>
                        <td>{{$pesanan->no_meja}}</td>
                        <td>{{$pesanan->nama_pemesan}}</td>
                        <td>{{$pesanan->jml}}</td>
                        <td>{{$pesanan->harga_bayar}}</td>
                        <td>{{$pesanan->sub_total}}</td>
                        <td>{{$pesanan->status}}</td>
                        <td>{{$pesanan->keterangan}}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="/pesananmasuk/update/{{$pesanan->id}}"
                                    class="btn btn-sm btn-info btn-icon">
                                    <i class="fas fa-edit"></i>
                                    Update
                                </a>
                            </div>
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
@endpush
