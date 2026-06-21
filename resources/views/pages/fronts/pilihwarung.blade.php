@extends('layouts.appfront')

@section('title', 'home')

@section('main')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Online Order System</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-sm-4">
        <div class="card">
            <img class="card-img-top" src="{{ Storage::url('gambarwarung/'.$warung->gambar_warung) }}" alt="Card image cap" style="height:250px; width:370px;">
            <div class="card-body">
              <h5 class="card-title">{{$warung->nama_warung}}</h5>
              <p class="card-text">{{$warung->deskripsi_warung}}</p>
              <a href="/home/{{$warung->id}}/lihatproduk" class="btn btn-primary">Lihat</a>
            </div>
          </div>
    </div>

  </div>
@endsection

