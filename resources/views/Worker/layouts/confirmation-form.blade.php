@extends('Worker.layouts.payment')

@section('form')
   @if (isset($error))
       @if ($error == '404')
           <center>
               <br><br>
               <h4 class="fw-bold text-dark-brown">Maaf, Data transaksi tidak dapat di temukan</h4>
               <br><br>
           </center>
       @endif
   @else
   <div class="container">
       <div class="row">
       @if ($data->bukti != '-')
      <div class="col-md-3">
        <br>
        <img src="/storage/{{$data->bukti }}" alt="" class="d-block w-100 img-fluid">
      </div>
      @endif
           <!-- Tabel Informasi Transaksi -->
           <div class="col-md-8">
               <div class="table-responsive">
                   <table class="table table-bordered mb-3">
                       <tr>
                           <td><strong>Nama</strong></td>
                           <td>:</td>
                           <td>{{ $data->first_name .' '.$data->last_name }}</td>
                       </tr>
                       <tr>
                           <td><strong>Username</strong></td>
                           <td>:</td>
                           <td>{{ $data->username }}</td>
                       </tr>
                       <tr>
                           <td><strong>Penerima</strong></td>
                           <td>:</td>
                           <td>{{ $data->penerima }}</td>
                       </tr>
                       <tr>
                       <td><strong>Status Pesanan</strong></td>
                        <td>:</td>
                        <td>
                            @php
                                // Menentukan warna dan deskripsi berdasarkan status
                                $statusColors = [
                                    'pending' => 'text-warning',
                                    'working' => 'text-success',
                                    'ready' => 'text-success',
                                    'ditolak' => 'text-danger'
                                ];

                                $statusDescriptions = [
                                    'pending' => 'Menunggu',
                                    'working' => 'Dikerjakan',
                                    'ready' => 'Pesanan Siap',
                                    'ditolak' => 'Ditolak'
                                ];

                                $currentStatus = $data->statusOrder;
                                $statusColor = $statusColors[$currentStatus] ?? 'text-dark';
                                $statusDescription = $statusDescriptions[$currentStatus] ?? 'Status Tidak Diketahui';
                            @endphp

                            <label class="fw-bold {{ $statusColor }}">
                                {{ $statusDescription }}
                            </label>
                        </td>

                       </tr>
                       <tr>
                           <td><strong>Subtotal</strong></td>
                           <td>:</td>
                           <td>Rp. {{ $data->subtotal }}</td>
                       </tr>
                       <tr>
                           <td><strong>Total Pesanan</strong></td>
                           <td>:</td>
                           <td>{{ $pesanan }}</td>
                       </tr>
                       <tr>
                           <td><strong>Metode Pembayaran</strong></td>
                           <td>:</td>
                           <td>
                           @if ($data->metodePembayaran == 'cash')
                            Cash
                            @else ($data->metodePembayaran)
                            Transfer Bank
                            @endif
                           </td>
                       </tr>
                       <tr>
                           <td><strong>Tempat Pengambilan</strong></td>
                           <td>:</td>
                           <td>                
                            @if ($data->pengambilan == 'drive')
                            Delivery Order
                            @elseif ($data->pengambilan == 'kasir')
                            Kasir
                            @else
                            {{$data->pengambilan}}
                            @endif
                           </td>
                       </tr>
                       <tr>
                           <td><strong>Tanggal Transaksi</strong></td>
                           <td>:</td>
                           <td>{{ date('d-m-Y', strtotime($data->date)) }}</td>
                       </tr>
                       <tr>
                           <td><strong>Tanggal Pengambilan</strong></td>
                           <td>:</td>
                           <td>{{ date('d-m-Y h:i:s A', strtotime($data->TanggalPengambilan)) }}</td>
                       </tr>
                       <tr>
                           <td><strong>Penerima</strong></td>
                           <td>:</td>
                           <td>{{ $data->penerima }}</td>
                       </tr>
                       <tr>
                           <td><strong>Catatan dan Alamat</strong></td>
                           <td>:</td>
                           <td>{{ $data->DeskripsiPemesanan }}</td>
                       </tr>
                   </table>
               </div>
           </div>

           <!-- Produk yang dibeli -->
           <div class="col-md-4">
               <h6><strong>Produk yang dibeli:</strong></h6>
               <div class="row" style="max-height:270px;overflow:auto;">
                   @foreach ($product as $items)
                       <div class="col-md-12 mb-3">
                           <div class="card">
                               <center>
                                   <img src="/storage/{{$items->image}}" class="img-fluid mt-2" style="max-width:100px;max-height:150px;" alt="...">
                               </center>
                               <div class="card-body">
                                   <p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                       <strong>{{ $items->product }}</strong>
                                       <br>
                                       Quantity: <strong>{{ $items->quantity }}</strong>
                                   </p>
                               </div>
                           </div>
                       </div>
                   @endforeach
               </div>
           </div>
       </div>

       <!-- Tombol-tombol Aksi -->
       <div class="row mt-3">
           @if ($statusTransaksi->status != 'ok')
               <div class="col">
                   <a href="/confirm/accept/{{ $data->id }}" class="btn btn-success col btn-sm w-100">Terima</a>
               </div>
           @endif

           <div class="col">
               <a class="btn btn-danger col btn-sm w-100" href="/confirm/decline/{{ $data->id }}">Tolak</a>
           </div>

           <!-- Tombol Nota -->
           @if ($statusTransaksi->status == 'ok')
               <div class="col">
                   <a href="{{ route('nota.cetak', ['id' => $data->id]) }}" class="btn btn-primary col btn-sm w-100">Cetak Nota</a>
               </div>
           @endif
       </div>
   </div>
   @endif
@stop
