@extends('layouts.appfront')

@section('title', 'home')

@section('main')


<div class="row">
    <div class="col-sm-12">
    <div class="card text-center">
        <div class="card-header">
          {{$warung->nama_warung}}
        </div>
      </div>
  </div>
</div>

<div class="row">
    @foreach ($produks as $produk)
    <div class="col-sm-4">
        <div class="card">
            <form action="{{ route('keranjang.store') }}" method="POST">
                @csrf
            <img class="card-img-top" src="{{ Storage::url('gambarproduk/'.$produk->path_gambar) }}" alt="Card image cap" style="height:250px; width:370px;">
            <div class="card-body">
              <h5 class="card-title">{{$produk->nama_produk}}</h5>
              <p class="card-text">Rp. {{$produk->harga}}</p>
              <?php if($produk->status_produk == 'tersedia'){ ?>
              <div class="form-group">
              <input type="number" name="jml" class="form-control" value="1">
              <input type="number" name="id_produk" class="form-control" value="{{$produk->id}}" hidden>
              <input type="number" name="harga_bayar" class="form-control" value="{{$produk->harga}}" hidden>
              <input type="text" name="id_warung" class="form-control" value="{{$warung->id}}" hidden>
              </div>
              <div class="form-group">
                <select class="form-control" name="id_meja">
                        <option value="0">-Pilih Meja-</option>
                    @foreach ($mejas as $meja)
                         <option value="{{$meja->id}}">{{$meja->no_meja}}</option>
                    @endforeach
                </select>
             </div>
              <button class="btn btn-primary">Pesan</button>
              <?php }else{ ?>
                  <h5>Habis</h5>
              <?php } ?>
            </form>
            </div>
          </div>
    </div>
    @endforeach
  </div>
@endsection

