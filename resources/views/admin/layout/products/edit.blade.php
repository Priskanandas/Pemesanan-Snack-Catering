@extends('admin.dashboard')
@section('content')
<div class="container">
    <br>
    <center>
        <h3>Edit Produk</h3>
    </center>
    <br>
    <div class="container">
        <a href="/admin/product/index" class="btn btn-sm btn-cokelat text-capitalize" >Kembali</a>
        <br>
    </div>
    <br>
   <div class="row">
       <div class="col-md-3">
            <center>
                <img src="/storage/{{$data->image}}" alt="" class="img-fluid img-thumbnail w-75">
            </center>
       </div>
       <div class="col mt-4">
        <form enctype="multipart/form-data" action="/admin/backend/product/update/{{$data->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="container">
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" placeholder="Nama produk :" value="{{ $data->product }}" name="product" id="product" class="col form-control form-control-sm">
                    </div>
                    <div class="col">
                        <input type="text" placeholder="Harga Produk :" value="{{ $data->price }}" name="price" id="product" class="col form-control form-control-sm">
                    </div>
                </div>
                <div class="col mb-3">
                <select name="category" id="category" class="form-control form-control-sm">
                    <option disabled hidden>Pilih Kategori Produk :</option>
                    <option value="Manis" {{ $data->category == 'Manis' ? 'selected' : '' }}>Manis</option>
                    <option value="Asin" {{ $data->category == 'Asin' ? 'selected' : '' }}>Asin</option>
                    <option value="PaketSnack" {{ $data->category == 'PaketSnack' ? 'selected' : '' }}>Paket Snack Box</option>
                    <option value="PaketNasi" {{ $data->category == 'PaketNasi' ? 'selected' : '' }}>Paket Nasi Box</option>
                </select>
                </div>

                <div class="col mb-3">
                    <input type="text" class="form-control form-control-sm" id="file" name="image" onfocus = "this.type='file'" placeholder="Foto Produk :">
                </div>
                <div class="col mb-3">
                <select name="status" id="status" class="form-control form-control-sm">
                    <option disabled hidden>Pilih status produk :</option>
                    <option value="open" {{ $data->status == 'open' ? 'selected' : '' }}>Ready</option>
                    <option value="closed" {{ $data->status == 'closed' ? 'selected' : '' }}>Habis</option>
                </select>
                </div>

                <div class="col mb-3">
                    <textarea name="description" id="description" class="form-control form-control-sm" placeholder="Deskripsi Produk :">{{ $data->description}}</textarea>
                </div>
                <div class="col">
                    <button class="btn btn-lg btn-cokelat w-100">Submit</button>
                </div>
            </div>
        </form>
       </div>
   </div>
</div>
@stop