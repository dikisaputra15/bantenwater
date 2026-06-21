@extends('layouts.appfront')

@section('title', 'List Pesanan')

@section('main')
<h1 class="h3 mb-2 text-gray-800">List Pesanan</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Pesanan</h6>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Meja</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Bayar</th>
                        <th>Sub Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i = 1)
                    @foreach ($keranjangs as $keranjang)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$keranjang->no_meja}}</td>
                        <td><img src="{{ Storage::url('gambarproduk/'.$keranjang->path_gambar) }}" style="width:60px; height:60px;"></td>
                        <td>{{$keranjang->nama_produk}}</td>
                        <td>{{$keranjang->jml}}</td>
                        <td>{{$keranjang->harga_bayar}}</td>
                        <td>{{$keranjang->sub_total}}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="/keranjang/delker/{{$keranjang->id}}"
                                    class="btn btn-sm btn-danger btn-icon confirm-delete" onclick="return confirm('Are you sure to delete this ?');">
                                    <i class="fas fa-times"></i>
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach

                <form action="/meja/storepesan" method="POST">
                    @csrf
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td>
                            {{$total}}
                            <input type="text" class="form-control" name="total_bayar" value="{{$total}}" hidden>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Atas Nama Pemesan</td>
                        <td>
                            <input type="text" class="form-control" name="nama_pemesan" placeholder="Nama Pemesan" required>
                            <input type="text" class="form-control" name="id_meja" value="{{$meja->id}}" hidden>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><button class="btn btn-primary">Lanjut Pesan</button></td>
                    </tr>
                </form>

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush
