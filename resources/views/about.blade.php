<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        .responsive-text{
            margin-top:5rem;
        }
        @media(max-width:676px){
            .responsive-text{
                margin-top:0;
                text-align:center;
            }
            .rw-img{
                display:none;
            }
        }
        .whatsapp-button {
            display: inline-flex;
            align-items: center;
            background-color: #25D366; /* Warna hijau WhatsApp */
            color: #fff;
            padding: 10px 15px; /* Padding di sekitar teks */
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            width: fit-content; /* Lebar tombol sesuai dengan ukuran teks */
            max-width: 100%; /* Menjaga tombol tidak lebih lebar dari kontainer */
            box-sizing: border-box; /* Memastikan padding dan border dihitung dalam lebar total */
            text-align: center; /* Mengatur teks agar rata tengah */
        }
        .whatsapp-button:hover {
            background-color: #128C7E; /* Warna hijau WhatsApp lebih gelap saat hover */
        }
        .whatsapp-button i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
<div class="bg-cream-tua">
    <div class="container">
        <nav class="navbar navbar-light bg-transparent mb-5">
            <div class="container-fluid">
              <a class="navbar-brand text-dark-brown text-roboto" href="/client/home">
                Kembali
             </a>
            </div>
        </nav>
        <div class="row">
            <div class=" responsive-text col-md-7 text-light">
                <h4 class="text-dark-brown text-roboto">Selamat Datang di <span class="text-darker-brown">Surya Catering</span></h4>
                <p style="text-align: justify;" class="text-darker-brown">
                Surya Catering adalah UMKM yang telah berdiri sejak 2013, menyediakan layanan catering dengan dedikasi untuk menghadirkan pengalaman kuliner yang luar biasa pada setiap kesempatan. 
          Dengan komitmen terhadap kualitas, kehalalan, dan pelayanan pelanggan yang ramah, kami menyajikan hidangan yang tidak hanya memuaskan selera tetapi juga menciptakan momen berharga.
          Didirikan dengan visi untuk memberikan layanan catering yang personal dan berkualitas tinggi, Surya Catering telah melayani berbagai pelanggan, 
          dari pesta pernikahan, hajatan, pengajian hingga acara sekolahan dan instansi pemerintahan. Kami percaya bahwa makanan yang lezat adalah bagian penting dari setiap acara.                </p>
            <br>
            </div>
            <div class="col">
                <img src="/img/maskot_umkm.png" alt="" class="img-fluid rw-img" data-aos="fade-left">
            </div>

                <h4 class="text-dark-brown text-roboto">Alamat <span class="text-darker-brown">Surya Catering</span></h4>
                <p style="text-align: justify;" class="text-darker-brown">
                Jl. Jogja km. 12 RT 01/RW 05 Krendetan, Kecamatan Bagelen, Kabupaten Purworejo, Provinsi Jawa Tengah              </p>
            <br>
            <h4 class="text-dark-brown text-roboto">Kontak <span class="text-darker-brown">Surya Catering</span></h4>
            <a href="https://wa.me/089603684703" class="whatsapp-button" target="_blank">
                <i class="fab fa-whatsapp"></i> Chat di WhatsApp
            </a>
            <br>
            <h4 class="text-dark-brown text-roboto">Nomer Rekening <span class="text-darker-brown">Surya Catering</span></h4>
                <p style="text-align: justify;" class="text-darker-brown">
                BRI : 6849 0100 6321 535 a/n PUDI HARTOMO            </p>
            <br>

        </div>
    </div>
</div>

<div class="bg-black-brown text-nunito">
    <div class="container">
        <center>
            <br>
                <h4 class="text-light">Beri Kami Testimoni Anda</h4>
            <br>
        </center>
        <form method="POST" action="/client/testimonial/store">
            <div class="container">
               @csrf
                <div class="col">
                    <textarea name="testimonial" id="testimonial" placeholder="Testimoni :" class="form-control col mb-4" cols="20" rows="5"></textarea>
                </div>
                <div class="col">
                    <button class="col btn-outline-light btn" style="width:100%;">Submit</button>
                </div>
                <br>
                <div class="col">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}  
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>  
                    @endif
                  @if (!empty($message))                 
                    @if($message->type =='error')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message->content }}  
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @else
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message->content }}  
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                  @endif
                </div>
            </div>
        </form>
    </div>
    <br>
</div>
</body>
</html>
<script>
    AOS.init();
</script>