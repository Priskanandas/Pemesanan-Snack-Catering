@extends('User')
@section('content')
<style>
        .carousel-item img {
            width: 100%; /* Mengatur lebar gambar menjadi 100% dari kontainer */
            height: 100%; /* Menyesuaikan tinggi gambar otomatis */
            object-fit: cover; /* Memastikan gambar mengisi kontainer tanpa distorsi */
            object-position: bottom;
        }
        .carousel-inner {
            max-height: 500px; /* Maksimal tinggi kontainer, sesuaikan sesuai kebutuhan */
            overflow: hidden;
        }
        .carousel{
          margin-top: 30px; /* sesuaikan dengan tinggi navbar Anda */
        }
    </style>
    <br>
    <div class="container">
        <form class="d-flex sticky-search-form" method="POST" action="/client/search">
            @csrf
            <input class="form-control form-control-sm me-2 col body-search" name="keyword" type="text" placeholder="Search...."  id="inputBody"/>
            <input type="submit" id="submit-body-search" style="display:none">
        </form>
        <br>
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="/img/pai buah.jpg" class="d-block w-100"  alt="...">
              </div>
              <div class="carousel-item">
                <img src="/img/putu ayu.jpg" class="d-block w-100"  alt="...">
              </div>
              <div class="carousel-item">
                <img src="/img/dadar gulung.jpg" class="d-block w-100"  alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          <br>
          <div class="row">
            <div class="responsive-pills">
                <span class="mb-2 fw-bold text-darker-brown text-nunito">Kategori : </span>
                <span class="ms-2">
                    <a class="btn btn-cokelat-muda  btn-sm col-1"  href="/client/category/Manis" style="border-radius:15px;">Manis</a>
                </span>
                <span class="ms-2">
                    <a class="btn btn-cokelat-muda  btn-sm col-1"  href="/client/category/Asin" style="border-radius:15px;">Asin</a>
                </span>
                <span class="ms-2">
                    <a class="btn btn-cokelat-muda  btn-sm col-1"  href="/client/category/PaketSnack" style="border-radius:15px;">Paket Snack Box</a>
                </span>
                <span class="ms-2">
                    <a class="btn btn-cokelat-muda  btn-sm col-1"  href="/client/category/PaketNasi" style="border-radius:15px;">Paket Nasi Box</a>
                </span>
            </div>
          </div>
          <br>
          <div class="row">
            @php
            $i = 0;
            @endphp
            @if ($type == 'default')
                @if (!empty($data) && $data->count())
                    @foreach ($data as $key=>$value )
                    @php
                    $i++
                    @endphp
                    <div class="col-md-3 mb-4">
                      <div class="card justify-content-center shadow" style="border-radius:10px; max-height:430px" data-aos="fade-up-right" data-aos-duration = "{{ 100 * $i }}">
                        <center>
                             <div class="bg-image hover-overlay ripple" data-bs-ripple-color="light">
                             <img
                             src="/storage/{{$value->image}}"
                             class="img-fluid mt-4" style="max-height:180px;max-width:260px; object-fit:cover;"
                             loading="lazy"
                           />
                           <a href="#!">
                             <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                           </a>
                         </div>
                         <div class="card-body justify-content-center">
                           <h5 class="card-title text-roboto">Rp.{{$value->price}}</h5>
                           <p class="card-text text-nunito" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                             {{$value->product}}
                           </p>
                           <a href="/product/detail/{{$value->id}}" class="btn btn-sm btn-cokelat col-md-5 text-nunito">Lihat Produk</a>
                         </div>
                           </center>
                         </div>
                       </div>
                     @endforeach
                @else
                <center>
                    <br><br>
                    <h2 class="text-dark-brown">Maaf, Tidak ada menu Untuk hari ini :(</h2>
                    <br><br>
                </center>
            @endif
            @else
                @if (!empty($data) && $data->count())
                    @foreach ($data as $key=>$value )
                    @php
                        $i++
                    @endphp
                    <div class="col-md-3 mb-4">
                        <div class="card justify-content-center shadow" style="border-radius:10px; max-height:430px" data-aos="fade-up-right" data-aos-duration = "{{ 100 * $i }}">
                          <center>
                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                            <img
                            src="/storage/{{$value->image}}"
                            loading="lazy"
                            class="img-fluid mt-4" style="max-height:200px;max-width:200px;"
                          />
                          <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                          </a>
                        </div>
                        <div class="card-body justify-content-center">
                          <h5 class="card-title text-roboto">Rp.{{$value->price}}</h5>
                          <p class="card-text text-nunito" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{$value->product}}
                          </p>
                          <a href="/product/detail/{{$value->id}}" class="btn btn-sm btn-cokelat col-md-5 text-nunito">Lihat Produk</a>
                        </div>
                          </center>
                        </div>
                      </div>
                     @endforeach
                @else
                    <center>
                        <br><br>
                        <h2 class="text-dark-brown">Maaf, Menu tidak ditemukan :(</h2>
                        <br><br>
                    </center>
                @endif
            @endif
        </div>
        <br>
        <center>
            @if ($type == 'default')
                {!! $data->links() !!}
            @endif
        </center>
        <br>
    </div>
</div>
<script>
  AOS.init();

    var navInput = document.getElementById('inputNav');
    var bodyInput = document.getElementById('inputBody');
    var btnInputnav = document.getElementById('submit-nav-search');
    var btnInputBody = document.getElementById('submit-body-search');
    navInput.addEventListener('keyup',function(event){
        if(event.key == 'Enter'){
            btnInputnav.click();
        }
    });
    bodyInput.addEventListener('keyup',function(event){
        if(event.key == "Enter"){
            btnInputBody.click();
        }
    });
</script>
@stop
