@extends('admin.dashboard')

@section('content')
<div class="container">
    <br>
    <h3>Rekap Transaksi</h3>
    <form action="{{ route('rekap.process') }}" method="POST">
        @csrf
        <div class="input-group mb-4">
            <label for="start_date">Tanggal Mulai:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required value="{{ old('start_date', session('start_date')) }}">
        </div>
        <div class="input-group mb-4">
            <label for="end_date">Tanggal Akhir:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required value="{{ old('end_date', session('end_date')) }}">
        </div>
        <button class="btn btn-cokelat-muda" type="submit">Rekap Data</button>
    </form>

    @if (session()->has('failed'))
        <div class="alert alert-danger mt-2">
            {{ session('failed') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('rekap_data'))
        <br>
        <h4>Hasil Rekap</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jumlah Penjualan</th>
                    <th>Status Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $index = 1;
                @endphp
                @foreach (session('rekap_data') as $date => $data)
                    @php
                        $totalForDate = $data['total'];
                        $status = $data['status'];
                        $total += $totalForDate;
                    @endphp
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $date }}</td>
                        <td>Rp. {{ number_format($totalForDate, 2, ',', '.') }}</td>
                        <td>
                        @if ($data['status'] === 'no')
                            <strong class="text-danger">Belum Diterima</strong>
                        @elseif ($data['status'] === 'ok')
                            <strong class="text-success">Sudah diterima</strong>
                        @else
                            <strong>-</strong>
                        @endif

                    </td>

                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Total Pendapatan</strong></td>
                    <td><strong>Rp. {{ number_format($total, 2, ',', '.') }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <form action="{{ route('rekap.exportPDF') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-cokelat-muda">Export PDF</button>
        </form>
    @endif
</div>
@stop
