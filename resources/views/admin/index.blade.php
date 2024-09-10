@extends('admin.dashboard')
@section('content')
<div class="container">
    <!-- Dashboard Section -->
    <div class="mb-4">
        <h3>Selamat datang kembali, {{ auth()->user()->username }}</h3>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Pengguna</h5>
                        <p class="card-text">{{ $userCount }}</p>
                        <a href="/admin/user/index" class="btn btn-light text-success">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-black">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Produk</h5>
                        <p class="card-text">{{ $productCount }}</p>
                        <a href="/admin/product/index" class="btn btn-light text-warning">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Transaksi</h5>
                        <p class="card-text">{{ $transactionCount }}</p>
                        <a href="/admin/transaksi/index" class="btn btn-light text-danger">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Section -->
    <div class="mb-4">
        <h4>Grafik Penjualan Produk Bulan {{ $month }}</h4>
        <div class="container">
            <label for="" class="mb-3">Daftar Produk Paling Diminati:</label>
            <canvas id="myChart" width="400" height="150"></canvas>
        </div>
    </div>
</div>

<script>
    // Ambil data dari server
    var data = @json($data);

    // Prepare data for chart
    var labels = [];
    var frequencies = [];

    data.forEach(function(item) {
        labels.push(item.product);
        frequencies.push(item.total);
    });

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Terjual',
                data: frequencies,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
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
@stop
