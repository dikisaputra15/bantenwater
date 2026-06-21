@extends('layouts.app')

@section('title', 'Users')

@push('style')

@endpush

@section('main')
<h1 class="h3 mb-2 text-gray-800">Form Tambah User</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah User</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Roles</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="roles" value="admin" class="radio"
                                checked="">
                            Admin
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="roles" value="pelanggan" class="radio">
                            Pelanggan
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="roles" value="kurir" class="radio">
                            Kurir
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="roles" value="pimpinan" class="radio">
                            Pimpinan
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')

@endpush
