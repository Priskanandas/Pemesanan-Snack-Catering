@extends('admin.layout.user.index')
@section('form')
<div class="col mb-3">
    <br>
    <center>
        <h5 class="fw-bold text-brown">Edit User</h5>
    </center>
    <br>
    <div class="container">
        <a href="/admin/user/index" class="btn btn-sm btn-cokelat text-capitalize">Kembali</a>
        <br>
    </div>
    <br>
    <form action="/admin/backend/user/update/{{$edit->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col">
                <input value="{{ $edit->first_name }}" type="text" id="first_name" name="first_name" placeholder="Nama Depan :" class="form-control form-control-sm col @error('first_name') is-invalid @enderror">
                @error('first_name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="col">
                <input value="{{ $edit->last_name }}" type="text" id="last_name" name="last_name" placeholder="Nama Belakang :" class="form-control form-control-sm col @error('last_name') is-invalid @enderror">
                @error('last_name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
        
        <div class="col mb-3">
            <input value="{{ $edit->username }}" type="text" class="form-control form-control-sm col @error('username') is-invalid @enderror" placeholder="Username :" name="username" id="username">
            @error('username')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        
        <div class="col mb-3">
            <!-- Display current profile image -->
            @if($edit->image && $edit->image != 'img/user.png')
                <div class="mb-2">
                    <img src="/storage/{{$edit->image}}" alt="Profile Image" class="img-thumbnail" style="max-width: 150px;">
                </div>
            @endif
            
            <!-- File input for new profile image -->
            <input type="file" name="profile" class="form-control col form-control-sm">
        </div>
        
        <div class="col mb-3">
            <input value="{{ $edit->email }}" type="email" name="email" id="email" class="form-control form-control-sm col @error('email') is-invalid @enderror" placeholder="E-mail :">
            @error('email')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        
        <div class="col mb-3">
            <select name="gender" id="gender" class="form-control form-control-sm @error('gender') is-invalid @enderror">
                <option value="" disabled hidden>Jenis Kelamin :</option>
                <option value="female" {{ $edit->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                <option value="male" {{ $edit->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
            </select>
            @error('gender')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        
        <div class="col mb-3">
            <select name="role" id="role" class="form-control form-control-sm @error('role') is-invalid @enderror">
                <option value="" disabled hidden>Role :</option>
                <option value="user" {{ $edit->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $edit->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="worker" {{ $edit->role == 'worker' ? 'selected' : '' }}>Worker</option>
            </select>
            @error('role')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        
        <div class="col mb-3">
            <input value="{{ $edit->tgl_lahir }}" type="date" id="tgl_lahir" name="tgl_lahir" class="form-control form-control-sm mb-3 @error('tgl_lahir') is-invalid @enderror">
            @error('tgl_lahir')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        
        <button type="submit" class="w-100 col btn-cokelat btn-sm btn">Submit</button>
    </form>
</div>
@stop
