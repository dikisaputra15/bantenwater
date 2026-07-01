@extends('layouts.app')

@section('title','Profil')

@push('style')

<style>

.profile-card{

    border:none;
    border-radius:20px;
    padding:40px;

}

.avatar{

    width:110px;
    height:110px;
    border-radius:50%;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;

}

.avatar i{

    font-size:70px;

}

.profile-title{

    font-size:55px;
    font-weight:bold;
    color:#4c63d8;

}

.form-control{

    height:60px;
    border-radius:12px;
    font-size:24px;
    background:#efefef;
    border:none;

}

.btn-save{

    width:250px;
    height:60px;
    font-size:28px;
    border-radius:12px;

}

</style>

@endpush

@section('main')

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<div class="text-center mb-4">

<div class="avatar">

<i class="mdi mdi-account"></i>

</div>

<div class="profile-title">

{{ auth()->user()->roles }}

</div>

</div>

<div class="card profile-card shadow">

<form action="{{ route('profile.update') }}" method="POST">

@csrf

<div class="form-group">

<input
type="text"
name="name"
class="form-control"
value="{{ auth()->user()->name }}"
placeholder="Nama">

</div>

<div class="form-group">

<input
type="text"
name="alamat"
class="form-control"
value="{{ auth()->user()->alamat_lengkap }}"
placeholder="Alamat">

</div>

<div class="form-group">

<input
type="email"
name="email"
class="form-control"
value="{{ auth()->user()->email }}"
placeholder="Email">

</div>

<div class="form-group">

<input
type="text"
name="no_hp"
class="form-control"
value="{{ auth()->user()->no_hp }}"
placeholder="No HP">

</div>

<div class="form-group">

<input
type="password"
name="password"
class="form-control"
placeholder="Password Baru">

</div>

<div class="text-center">

<button class="btn btn-primary btn-save">

Simpan

</button>

</div>

</form>

</div>

@endsection
