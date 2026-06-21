@extends('layouts.app')

@section('title', 'Edit Meja')

@push('style')

@endpush

@section('main')
<h1 class="h3 mb-2 text-gray-800">Form Edit Meja</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Meja</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('meja.update', $meja->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label>Nomor Meja</label>
                    <input type="text" class="form-control" name="no_meja" value="{{ $meja->no_meja }}">
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
