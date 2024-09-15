@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Index')

@section('content_body')

    <div class="row">
        <div class="col-lg-3 col-6">

            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $baru }}</h3>
                    <p>Pengajuan Reimburse Baru</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $reviewHR }}</h3>
                    <p>Review HR</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $reviewFinance }}</h3>
                    <p>Review Finance</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $processed }}</h3>
                    <p>Reimburse Diproses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card-body">
                <div>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-body">
                <div>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop
@section('userjs')
    <script>
        const barCtx = document.getElementById('barChart');

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [{
                    label: 'Jumlah Reimburse',
                    data: {!! json_encode($barCharts) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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

        var pieLabels = {!! json_encode($pieLabels) !!};
        var pieData = {!! json_encode($pieData) !!};
        var pieCtx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels, // Category names
                datasets: [{
                    label: 'Jumlah Reimburse per Kategori',
                    data: pieData, // Count of reimbursements per category
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)', // Blue
                        'rgba(255, 99, 132, 0.5)', // Red
                        'rgba(75, 192, 192, 0.5)', // Green
                        'rgba(153, 102, 255, 0.5)', // Purple
                        'rgba(255, 206, 86, 0.5)'  // Yellow
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)', // Blue
                        'rgba(255, 99, 132, 1)', // Red
                        'rgba(75, 192, 192, 1)', // Green
                        'rgba(153, 102, 255, 1)', // Purple
                        'rgba(255, 206, 86, 1)'   // Yellow
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

    </script>
@stop
