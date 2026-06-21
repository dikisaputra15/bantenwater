@extends('layouts.app')

@section('title', 'Laporan Warung Terlaris')

@push('style')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('main')
<h1 class="h3 mb-2 text-gray-800">Laporan Warung Terlaris</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Grafik Laporan Warung Terlaris</h6>
    </div>
    <div class="card-body">

        <canvas id="warungChart" width="400" height="200"></canvas>

    </div>
</div>

@endsection

@push('scripts')

<script>
    var ctx = document.getElementById('warungChart').getContext('2d');
    var warungChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($datawarung->pluck('warung')),
            datasets: [{
                label: 'Total Penjualan',
                data: @json($datawarung->pluck('total')),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endpush
