@extends('User')
@section('content')
<br><br>
<div class="container bg-light shadow">
    <br><br>
    <center>
        <h3 class="fw-bold">
            @if($method != 'cash') Transaksi telah berhasil di kirim @else Pembayaran akan dilakukan ketika anda sudah datang @endif, anda dapat kembali melanjutkan belanja anda. 
        </h3>
        <p>
            Petunjuk : Kode transaksi anda akan muncul di bagian Profil, Gunakan Kode Transaksi untuk mengambil Pesanan Anda.
        </p>
        <div class="container">
            <div class="alert-warning alert fw-bold">
                Kode Transaksi Yang berada di profil anda bersifat Rahasia.
            </div>
        </div>
        <p>
            <a href="/" class="btn col-md-3 btn-cokelat-muda">Kembali</a>
            <br>
        </p>
        <br>
    </center>
</div>

@stop
