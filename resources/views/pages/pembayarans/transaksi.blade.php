@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('main')
<h1 class="h3 mb-2 text-gray-800">Laporan Penjualan</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Berdasarkan Tanggal</h6>
    </div>
        <form action="/pdfpenjualan" method="POST" target="__blank">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" name="start_date" required>
                </div>

                <div class="form-group">
                    <label>Sampai Dengan Tanggal</label>
                    <input type="date" class="form-control" name="end_date" required>
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary">Filter</button>
            </div>
        </form>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
