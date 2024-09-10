@extends('admin.dashboard')
@section('content')
<div class="row">
  <center>
    <h3>Data-data Transaksi</h3>
  </center>
</div><br>
<div class="row">
  <form action="/admin/backend/transaksi/search" method="post">
    @csrf
    <div class="input-group mb-4">
      <input name="search" type="text" class="form-control" placeholder="Search ..." aria-describedby="search" value="{{ request('search') }}">
      <br>
      <select name="status_pembayaran" class="form-control">
        <option value="">Status Pembayaran</option>
        <option value="ok" {{ request('status_pembayaran') == 'ok' ? 'selected' : '' }}>Diterima</option>
        <option value="no" {{ request('status_pembayaran') == 'no' ? 'selected' : '' }}>Belum Diterima</option>
      </select>

      <select name="status_order" class="form-control">
        <option value="">Status Order</option>
        <option value="pending" {{ request('status_order') == 'pending' ? 'selected' : '' }}>Menunggu</option>
        <option value="working" {{ request('status_order') == 'working' ? 'selected' : '' }}>Dikerjakan</option>
        <option value="ready" {{ request('status_order') == 'ready' ? 'selected' : '' }}>Pesanan Siap</option>
        <option value="ditolak" {{ request('status_order') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
      </select>

      <button class="btn btn-cokelat-muda" type="submit" id="search">Search & Filter</button>
    </div>
  </form>
</div>
<div class="row">
  @if($data->count())
  @foreach ($data as $item)
  <div class="col-md-4">
    <div class="card shadow">
      <div class="card-body">
        <h5 class="card-title">Kode Transaksi : <span>{{$item->kodetransaksi}}</span></h5>
        @php
          $fullName = $item->first_name . ' ' . $item->last_name;
          $currentStatus = $statusorder[$item->kodetransaksi]->status ?? 'Status Tidak Diketahui';
          $statusColors = ['pending' => 'text-warning', 'working' => 'text-success', 'ready' => 'text-success', 'ditolak' => 'text-danger'];
          $statusDescriptions = ['pending' => 'Menunggu', 'working' => 'Dikerjakan', 'ready' => 'Pesanan Siap', 'ditolak' => 'Ditolak'];
          $statusColor = $statusColors[$currentStatus] ?? 'text-dark';
          $statusDescription = $statusDescriptions[$currentStatus] ?? 'Status Tidak Diketahui';
        @endphp
        <p class="card-text">
          <table>
            <tr>
              <td>Tanggal Transaksi</td>
              <td>:</td>
              <td>{{ date('d-m-Y', strtotime($item->tanggalTransaksi)) }}</td>
            </tr>
            <tr>
              <td>Penerima </td>
              <td>:</td>
              <td>{{$item->penerima}}</td>
            </tr>
            <tr>
              <td><strong>Status Pesanan</strong></td>
              <td>:</td>
              <td>
                <label class="fw-bold {{ $statusColor }}">{{ $statusDescription }}</label>
              </td>
            </tr>
            <tr>
              <td>Status Transaksi</td>
              <td>:</td>
              <td>
                @if ($item->statusTransaksi == 'ok')
                  <strong class="text-success">Transaksi Diterima</strong>
                @else
                  <strong class="text-danger">Transaksi Belum Diterima</strong>
                @endif
              </td>
            </tr>
            <tr>
              <td>Nama </td>
              <td>:</td>
              <td>{{$fullName}}</td>
            </tr>
            <tr>
              <td>Username </td>
              <td>:</td>
              <td>{{$item->username}}</td>
            </tr>
            <tr>
              <td>E-mail </td>
              <td>:</td>
              <td>{{$item->email}}</td>
            </tr>
          </table>
        </p>
        <a href="/admin/transaksi/detail/{{$item->idTransaksi}}" class="btn btn-cokelat btn-sm">Lihat Lebih</a>
      </div>
    </div>
  </div>
@endforeach

  @else
    <center>
      <br><br>
      <h3>Tidak ada Data</h3>
    </center>
  @endif
</div>
@endsection
