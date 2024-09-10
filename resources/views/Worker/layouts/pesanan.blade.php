@extends('Worker.dashboard')
@section('pesanan')
@if (session()->has('success'))
<div class="alert alert-success d-flex align-items-center w-100 alert-dismissible fade show" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
        {{ session('success') }}
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<!-- Formulir Filter -->
<form method="GET" action="{{ route('order.filter') }}" class="mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="filter_by_date" class="col-form-label">Filter Berdasarkan:</label>
            <select name="filter_by_date" id="filter_by_date" class="form-select">
                <option value="">Pilih Kriteria</option>
                <option value="transaction_date" {{ request('filter_by_date') == 'transaction_date' ? 'selected' : '' }}>Tanggal Transaksi</option>
                <option value="pickup_date" {{ request('filter_by_date') == 'pickup_date' ? 'selected' : '' }}>Tanggal Pengambilan</option>
            </select>
        </div>
        <div class="col-auto">
            <label for="sort_order" class="col-form-label">Urutkan Berdasarkan:</label>
            <select name="sort_order" id="sort_order" class="form-select">
                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Lama ke Baru</option>
                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Baru ke Lama</option>
            </select>
        </div>
        <div class="col-auto">
            <label for="status" class="col-form-label">Status:</label>
            <select name="status" id="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="working" {{ request('status') == 'working' ? 'selected' : '' }}>Dikerjakan</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Pesanan Siap</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-cokelat col w-100 mb-3">Filter</button>
        </div>
    </div>
</form>


 <div class="row">
  @foreach ($data as $item)      
    <div class="col-md-4 mb-4">
        <div class="card shadow" style="">
            <div class="card-body">
              <h5 class="card-title">{{ $item->username }}</h5>
              <p class="card-text">
              <label>Tanggal Transaksi : {{ date('d-m-Y', strtotime($item->date)) }}</label>
              <label>Tanggal Pengambilan : {{ date('d-m-Y H:i:s A', strtotime($item->TanggalPengambilan)) }}</label>
                @php
                // Menentukan warna dan deskripsi berdasarkan status
                $statusColors = [
                    'pending' => 'color: yellow;',
                    'working' => 'color: green;',
                    'ready' => 'color: green;',
                    'ditolak' => 'color: red;'
                ];

                $statusDescriptions = [
                    'pending' => 'Menunggu',
                    'working' => 'Dikerjakan',
                    'ready' => 'Pesanan Siap',
                    'ditolak' => 'Ditolak'
                ];

                $currentStatus = $item->status;
                $statusColor = $statusColors[$currentStatus] ?? 'color: black;';
                $statusDescription = $statusDescriptions[$currentStatus] ?? 'Status Tidak Diketahui';
            @endphp

            <label class="text-capitalize fw-bold" style="{{ $statusColor }}">
                Status Pesanan: {{ $statusDescription }}
            </label><br>
                <label>Sub Total : Rp.{{ $item->subtotal }}</label>
              </p>
              <div class="row">
                <div class="col">
                  @if ($item->status == 'pending')
                    <a href="/order/accept/{{$item->id}}" class="btn btn-primary col w-100 btn-sm" >Terima Pesanan</a>
                  @elseif ($item->status == 'working')
                    <a href="/order/finish/{{$item->id}}" class="btn btn-success col w-100 btn-sm" >Pesanan Siap</a>
                   @endif
                </div>
                  <div class="col">
                    <a href="/order/show/{{$item->id}}" class="btn btn-primary col w-100 btn-sm">Lihat Pesanan</a>
                  </div>
                  <div class="col">
                      @if ($item->status == 'pending')
                          <a href="/order/decline/{{$item->id}}" class="btn btn-danger col w-100 btn-sm">Tolak Pesanan</a>
                      @endif
                  </div>
                                   
                    <!-- Tambahkan link untuk menghapus pesanan -->
                    @if ($item->status == 'ditolak')
                <div class="col">
                    <!-- Tambahkan link untuk menghapus pesanan -->
                    <form action="{{ route('order.destroy', ['id' => $item->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Apa anda ingin menghapus data ini ?')" class="btn btn-danger col w-100 btn-sm">Hapus</button>
                    </form>
                </div>
                @endif

              </div>
            </div>
          </div>
    </div>
  @endforeach

</div>      
@stop