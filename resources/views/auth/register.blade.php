@extends('layouts.auth')

@section('title', 'Register')

@section('main')
<div class="row w-100 mx-0">
    <div class="col-lg-4 mx-auto">
        <div class="auth-form-light text-left py-5 px-4 px-sm-5">

            <div class="brand-logo">
                <h3>Register</h3>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <input type="text"
                           class="form-control form-control-lg"
                           name="name"
                           placeholder="Nama"
                           value="{{ old('name') }}"
                           required>
                </div>

                <div class="form-group">
                    <input type="email"
                           class="form-control form-control-lg"
                           name="email"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="form-group">
                    <input type="password"
                           class="form-control form-control-lg"
                           name="password"
                           placeholder="Password"
                           required>
                </div>

                <div class="form-group">
                    <input type="text"
                           class="form-control form-control-lg"
                           name="alamat_lengkap"
                           placeholder="Alamat Lengkap"
                           required>
                </div>

                 <div class="form-group">
                    <input type="text"
                           class="form-control form-control-lg"
                           name="no_hp"
                           placeholder="No Hp"
                           required>
                </div>

                <div class="mt-3">
                    <button type="submit"
                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                        Daftar
                    </button>
                </div>

                <!-- <div class="text-center mt-4 font-weight-light">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-primary">
                        Login
                    </a>
                </div> -->

            </form>

        </div>
    </div>
</div>
@endsection
