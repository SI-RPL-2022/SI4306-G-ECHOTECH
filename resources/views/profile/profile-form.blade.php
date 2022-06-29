@extends('layouts.main')

<link rel="stylesheet" href="/css/landing.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

@section('container')

<section class="header">
    <form action="update-profile" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="container">
            <div class="row profile-header">
                <div class="col-md-7 isi-header">
                    <div class="row">
                        <h3 class="judul-akun" style="font-size: 28px">Pengaturan Akun</h3>
                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show fade in" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show fade in" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if($errors)
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show fade in">{{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div style="padding-left:4.5rem; padding-right:4rem;padding-bottom:3.5rem">
            <div class="card">
                <div class="container">
                    <div class="row p-5 mt-2">
                        <h4 style="font-weight: bold; font-size: 24px; color: #343A40">Detail Profil</h4>
                        <div class="d-flex mb-5">
                            @if(auth()->user()->profile_photo_path !="")
                            <img src="/image/photo-profile/{{auth()->user()->profile_photo_path}}"
                                style="width: 4cm;height:5cm">
                            @else
                            <img src="/image/photo-profile/default_photo.png" style="width: 4cm;height:4cm"
                                class="rounded-circle me-3">
                            @endif
                            <div class="ms-5 mt-4">
                                <input type="file" name="photo_path" class="btn btn-success btn-sm me-1">
                                <button class="sec-btn btn-danger btn-sm">Mengatur Ulang</button>
                                <p style="color:firebrick">*Foto dalam bentuk .jpg atau .png</p>
                            </div>
                        </div>
                        <div class="col">
                            <label for="formGroupExampleInput" class="form-label fw-bold">Nama Depan</label>
                            <input type="text" name="first" class="form-control" value="{{auth()->user()->first_name}}"
                                placeholder="First Name" aria-label="First name">
                            <label for="formGroupExampleInput" class="form-label mt-2 fw-bold">Nama Belakang</label>
                            <input type="text" name="last" class="form-control" value="{{auth()->user()->last_name}}"
                                placeholder="Last Name" aria-label="Last name">
                            <label for="formGroupExampleInput" class="form-label mt-2 fw-bold">Email</label>
                            <input type="text" name="email" class="form-control" value="{{auth()->user()->email}}"
                                placeholder="Email" aria-label="Email">
                            <label for="formGroupExampleInput" class="form-label mt-2 fw-bold">Negara</label>
                            <input type="text" name="country" class="form-control" value="{{auth()->user()->country}}"
                                placeholder="Country" aria-label="Country">
                        </div>
                        <div class="col">
                            <label for="formGroupExampleInput" class="form-label fw-bold">No. Rekening</label>
                            <input type="text" name="accnum" class="form-control"
                                value="{{auth()->user()->account_number}}" placeholder="Account Number"
                                aria-label="Account Number">
                            <label for="formGroupExampleInput" class="form-label mt-2 fw-bold">Alamat</label>
                            <textarea type="text" name="address" class="form-control" placeholder="Address"
                                aria-label="Address">{{auth()->user()->address}}</textarea>
                            <label for="formGroupExampleInput" class="form-label mt-2 fw-bold">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{auth()->user()->phone_number}}" placeholder="Phone Number"
                                aria-label="Phone Number">
                            <label for="formGroupExampleInput" class="form-label mt-2 fw-bold">Provinsi</label>
                            <input type="text" name="province" class="form-control" value="{{auth()->user()->province}}"
                                placeholder="Province" aria-label="Province">
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-success btn-sm me-1" name="submit-profile" type="submit">Simpan
                                Perubahan</button>
                            <button class="sec-btn btn-danger btn-sm" name="cancel" type="submit">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="update-password" method="POST">
        @csrf
        <div class="container">
            <div class="row">
                <div class="row">
                    <h3 class="me-0" style="font-size: 28px; font-weight:bold;">Ganti Kata Sandi</h3>
                </div>
            </div>
        </div>
        <div style="padding-left:4.5rem; padding-right:4rem;padding-bottom:3.5rem">
            <div class="card">
                <div class="container">
                    <div class="row p-5">
                        <div class="col">
                            <label for="formGroupExampleInput" class="form-label fw-bold">Old Password</label>
                            <input type="password" name="old_pass" class="form-control" placeholder="Old Password"
                                aria-label="Old Password" id="pass1" required>
                        </div>

                        <div class="col">
                            <label for="formGroupExampleInput" class="form-label fw-bold">New Password</label>
                            <input type="password" name="new_pass" class="form-control" placeholder="New Password"
                                aria-label="Confirm Password" required>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-success btn-sm me-1" type="submit">Simpan
                                Perubahan</button>
                            <button class="sec-btn btn-danger btn-sm" name="cancel" type="submit">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>


@endsection