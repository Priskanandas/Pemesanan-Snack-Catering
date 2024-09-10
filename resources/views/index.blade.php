<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Surya Catering - {{$title}}</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script type="text/javascript" src="/js/jquery.js"></script>
  <script type="text/javascript" src="/js/vue.js"></script>
  <script type="text/javascript" src="/js/aos.js"></script>
  
  <link rel="stylesheet" href="/css/master.css">
  <link rel="stylesheet" href="/css/aos.css">
  <title>Surya Catering - {{$title}}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    @media(max-width:767px){
      .gambar{
        display:none;
      }
      .responsive-testimonial{
        text-align:center;
      }
    
    }
  </style>
</head>
<body>
  <div class="bg-light-cream">
    <nav class="navbar navbar-expand-lg navbar-light text-nunito" style="background:transparent;">
      <div class="container">
        <a class="navbar-brand text-dark-brown fw-bold" style="color:#967259;" href="#">SuryaCatering</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto justify-content-right">
            <li class="nav-item hover-menu ms-2">
              <a class="nav-link active" aria-current="page" style="color:#967259;" href="/client/menu">Menu</a>
            </li>
            <li class="nav-item hover-menu ms-2">
              <a class="nav-link" style="color:#967259;" href="/client/about">Tentang</a>
            </li>

            @guest
            <li class="nav-item hover-menu ms-2">
              <a class="nav-link" style="color:#967259;" href="/register">Register</a>
            </li>
            <li class="nav-item hover-menu ms-2">
              <a class="nav-link" style="color:#967259;" href="/login">Login</a>
            </li>
            @endguest
            @auth
            <li class="nav-item hover-menu ms-2">
              <a class="fas fa-shopping-cart" style="color:#967259; margin-top: 12px; font-size: 20px;" href="/client/cart/" aria-current="page"></a>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle align-items-center hidden-arrow text-light nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle" src="@if (Auth::user()->image && Auth::user()->image != 'img/user.png')
                            /storage/{{ Auth::user()->image }}
                        @else
                            /img/user.png
                        @endif" width="25"  height="25" alt="" loading="lazy"/>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @auth
                      <li>
                        <a class="dropdown-item" href="/client/profile">Profil</a>
                      </li>
                    @endauth
                 
                    <li>
                        @if(Auth::user()->role == 'admin')
                          <a class="dropdown-item" href="/admin/dashboard" aria-expanded="false">
                            Admin Panel
                          </a>
                        @elseif(Auth::user()->role == 'worker' || Auth::user()->role == 'admin')
                          <a class="dropdown-item" href="/worker/dashboard" aria-expanded="false">
                            Worker Panel
                          </a>
                        @endif
                    </li>

                    @auth
                    <li class="nav-item">
                        <a class="dropdown-item" href="/logout">Log Out</a>
                    </li>
                    @endauth
                  </ul>
            </li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>
    <div class="container text-roboto mt-5">
      <div class="row">
        <div class="col-md-7">
          <br>
          <h3 style="color: #36454F; font-weight: normal; font-size: 2.5rem; line-height: 1.2;">Selamat Datang, <br>
            <span>di
              <span class="fw-bold text-dark-brown">Surya Catering</span>
            </span>
           </h3>
           <br>
           <p class="col-md-8 rw-p text-nunito"  style="text-align: justify;">Snack Box di Surya Catering memiliki pilihan yang beragam, dengan bahan-bahan terbaik sehingga rasa dan tampilan akan memuaskan tamu di acara yang anda adakan.</p>
          </div>
         <div class="col gambar">
          <img src="/img/bgchef.png" alt="" class="img-fluid" data-aos="fade-up" data-aos-duration="1000">
         </div>
      </div>
    </div>
  </div>
  <div class="bg-dark-brown">
    <div class="container">
      <center>
        <br>
        <h3 class="fw-bold text-roboto text-light">Tentang Kami</h3>
        <br>
      </center>
      <div class="row">
        <div class="col-md-4">
          <img src="/img/maskot_umkm.png" alt="" class="img-fluid" data-aos="fade-right">
        </div>
        <div class="col text-light text-nunito">
          <p style="text-align: justify;">
          Surya Catering adalah UMKM yang telah berdiri sejak 2013, menyediakan layanan catering dengan dedikasi untuk menghadirkan pengalaman kuliner yang luar biasa pada setiap kesempatan. 
          Dengan komitmen terhadap kualitas, kehalalan, dan pelayanan pelanggan yang ramah, kami menyajikan hidangan yang tidak hanya memuaskan selera tetapi juga menciptakan momen berharga.
          Didirikan dengan visi untuk memberikan layanan catering yang personal dan berkualitas tinggi, Surya Catering telah melayani berbagai pelanggan, 
          dari pesta pernikahan, hajatan, pengajian hingga acara sekolahan dan instansi pemerintahan. Kami percaya bahwa makanan yang lezat adalah bagian penting dari setiap acara.
          </p>
          <a href="/client/about" class="btn btn-outline-light col-md-3"> Selengkapnya</a>
        </div>
      </div>
    </div>
    <br>
  </div>
  <div class="bg-black-brown">
    <div class="container text-light text-center">
      <br>
        <br>
          <h3 class="fw-bold text-light text-roboto">Kenapa Harus Kami?</h3>  
        <br>  
      <div class="row">
        <div data-aos="fade-up" data-aos-duration="1000" class="col-md-4">
            <h5 class="text-roboto">Sepesialis Snack Box</h5>
            <p class="text-nunito">
            Dengan beragam pilihan macam menu, Surya Catering membantu anda mempersiapkan acara yang akan berlangsung, seperti menyediakan snack box untuk rapat, seminar, pengajian, ulang tahun, dan gathering.            </p>
        </div>
        <div data-aos="fade-up" data-aos-duration="2000" class="col-md-4">
          
            <h5 class="text-roboto">Delivery Order</h5>
            <p class="text-nunito">
            layanan di mana pesanan yang anda buat akan diantarkan oleh kami atau layanan pengiriman makanan ke alamat yang diinginkan, free ongkir hanya berlaku pada jarak kurang dari 6 km.
            </p>
        </div>
        <div data-aos="fade-up" data-aos-duration="3000" class="col-md-4">
          
            <h5 class="text-roboto">Pemesanan Mudah</h5>
            <p class="text-nunito">
            Pemesanan H-1 dengan admin yang selalu siap melayani anda dan fast respon membuat proses pemesanan mudah dan cepat.
            </p>
        </div>
      </div>
      <br>
      <br>
    </div>    
  </div>
  <div class="bg-light-cream">
    <div class="container">
        <br>
          <h3 class="text-roboto text-center text-dark-brown">Menu Kami</h3>
        <br>
        <div class="row">
          @php
            $i= 0+1;
          @endphp
          @foreach ($data as $produk)
            @php
              $i++;
            @endphp
          <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-duration="{{ $i * 1000}}">
            <div class="card justify-content-center shadow" style="border-radius:10px;">
            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
              <center>
                <br>  
                <img
                src="/storage/{{$produk->image}}"
                class="img-fluid" style="max-height:180px;max-width:260px; object-fit:cover;"
              />
              </center>
              <a href="#!">
                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
              </a>
            </div>
            <br>
            <div class="card-body justify-content-center">
             <center>
              <h5 class="card-title">Rp.{{$produk->price}}</h5>
              <p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{$produk->product}}
              </p>
              <a href="/product/detail/{{$produk->id}}" class="btn btn-sm btn-cokelat col-md-5">Lihat Produk</a>
             </center>
            </div>
          </div>
          </div>
          @endforeach
        </div>
        <br>
        <br>
        <center>
          <a href="/client/menu" class="col-md-3 btn  btn-cokelat btn-lg text-nunito"  style="background:transparent;">Lebih Banyak Produk</a>  
        </center> 
        <br> 
      </div>
    </div>
    <script>
      console.log([[{"id":2,"userId":"2","email":"pretty@icloud.com","username":"GeneralPretty","testimoni":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, esse. Sunt, vitae excepturi in ea temporibus maxime adipisci autem neque expedita mollitia placeat illum natus ipsa reprehenderit doloribus delectus voluptatem!","created_at":"2021-10-14T04:09:41.000000Z","updated_at":"2021-10-14T04:09:41.000000Z"},{"id":4,"userId":"2","email":"pretty@icloud.com","username":"GeneralPretty","testimoni":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, esse. Sunt, vitae excepturi in ea temporibus maxime adipisci autem neque expedita mollitia placeat illum natus ipsa reprehenderit doloribus delectus voluptatem!","created_at":"2021-10-14T04:10:31.000000Z","updated_at":"2021-10-14T04:10:31.000000Z"}],{"2":{"id":3,"userId":"2","email":"pretty@icloud.com","username":"GeneralPretty","testimoni":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, esse. Sunt, vitae excepturi in ea temporibus maxime adipisci autem neque expedita mollitia placeat illum natus ipsa reprehenderit doloribus delectus voluptatem!","created_at":"2021-10-14T04:09:56.000000Z","updated_at":"2021-10-14T04:09:56.000000Z"},"3":{"id":1,"userId":"2","email":"pretty@icloud.com","username":"GeneralPretty","testimoni":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, esse. Sunt, vitae excepturi in ea temporibus maxime adipisci autem neque expedita mollitia placeat illum natus ipsa reprehenderit doloribus delectus voluptatem!","created_at":"2021-10-14T04:09:08.000000Z","updated_at":"2021-10-14T04:09:08.000000Z"}}])
    </script>
    {{-- {{$testimonial->chunk(2)}} --}}
    <div class="bg-dark-brown">
      <div class="container">
        <br>
        <h4 class="text-center text-light text-roboto">Testimoni</h4>
        <br>
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            @php
                $u = 0;
            @endphp
            @foreach ($testimonial->chunk(2) as $first)
            @php
            $u++;
            @endphp    
                <div class="carousel-item @if ($u == 1) active @endif">
                  <div class="row justify-content-center">
                    
                    @foreach ($first as $resource)
                    <div class="col-lg-6 responsive-testimonial">
                      <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                          <div class="col-md-4 mt-4">
                            <img
                              src="@if ($resource->image =='user.png')
                                /img/user.png
                              @else
                                /storage/{{$resource->image}}              
                              @endif"
                              alt="..."
                              style="width:150px;height:150px;object-fit:cover;"
    
                              class="img-fluid rounded-circle  ms-4"
                            />
                          </div>
                          <div class="col-md-8 mt-3">
                            <div class="card-body">
                              <h5 class="card-title text-roboto">{{$resource->first_name.' '.$resource->last_name}}</h5>
                              <p class="card-text fw-light text-nunito" style="   display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;   overflow:hidden;">
                                {{$resource->testimoni}}
                              </p>
                              <p class="card-text">
                                <small class="text-muted fw-light text-nunito">Customer</small>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                @endforeach
              </div>
            </div>
            @endforeach
          </div>
        </div>
        <br>
      </div>
    </div>
    <footer class="bg-light-cream text-center text-lg-start text-nunito text-dark-brown fw-bold">
      <div class="text-center p-3">
        © 2024 Copyright:
        <a class="text-dark-brown" href="/">SuryaCatering</a>
      </div>
    </footer>
</body>
</html>
<script>
  AOS.init();
</script>