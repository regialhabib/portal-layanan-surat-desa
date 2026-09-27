@extends('layouts.main')

@push('style')
    <!-- Sweet Alert-->
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('main-content')


    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        <div class="col-lg-4 order-lg-2">
            <form method="POST" autocomplete="off" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                <div class="card shadow mb-4">
                    <div class="card-profile-image mt-4 text-center">

                        <img id="previewImage"
                            src="{{ auth()->user()->foto ? asset('storage/profile/' . auth()->user()->foto) : asset('images/users/avatar-1.jpg') }}"
                            class="rounded-circle shadow" style="height:180px;width:180px;object-fit:cover;cursor:pointer;"
                            alt="Profile Image">

                        <!-- input file disembunyikan -->
                        <input type="file" name="foto" id="fotoInput" style="display:none">

                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <h5 class="font-weight-bold">{{ auth()->user()->role }}</h5>
                                <p>{{ auth()->user()->email ?? 'User' }}</p>
                            </div>
                        </div>

                        {{-- <div class="row text-center">
                        <div class="col-md-4">
                            <span class="heading">22</span>
                            <span class="description">Friends</span>
                        </div>
                        <div class="col-md-4">
                            <span class="heading">10</span>
                            <span class="description">Photos</span>
                        </div>
                        <div class="col-md-4">
                            <span class="heading">89</span>
                            <span class="description">Comments</span>
                        </div>
                    </div> --}}
                    </div>
                </div>


        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Saya</h6>
                </div>

                <div class="card-body">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">



                    <div class="pl-lg-4">
                        <div class="row mb-3">
                            {{-- <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="name">Nama<span
                                            class="small text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="nama"
                                        value="{{ auth()->user()->nama }}" placeholder="Name">
                                </div>
                            </div> --}}
                            <div class="col-lg-12">
                                <label class="form-control-label" for="username">Email<span
                                        class="small text-danger">*</span></label>
                                <input type="email" id="username" class="form-control" name="email"
                                    placeholder="example@example.com" value="{{ auth()->user()->email }}">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="current_password">Password Sekarang</label>
                                <input type="password" id="current_password" class="form-control" name="current_password"
                                    placeholder="Password Sekarang">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="new_password">Password Baru</label>
                                <input type="password" id="new_password" class="form-control" name="new_password"
                                    placeholder="Password Baru">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group focused">
                                <label class="form-control-label" for="confirm_password">Konfirmasi Password</label>
                                <input type="password" id="confirm_password" class="form-control"
                                    name="password_confirmation" placeholder="Konfirmasi Password">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button -->
                <div class="pl-lg-4 mb-3">
                    <div class="row">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
                </form>

            </div>

        </div>

    </div>

    </div>
@endsection

@push('script')
    <!-- Sweet Alerts js -->
    <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}'
            });
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const previewImage = document.getElementById("previewImage");
            const fotoInput = document.getElementById("fotoInput");

            if (previewImage && fotoInput) {

                previewImage.addEventListener("click", function() {
                    console.log("klik foto");
                    fotoInput.click();
                });

                fotoInput.addEventListener("change", function(e) {

                    const file = e.target.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                        }

                        reader.readAsDataURL(file);
                    }

                });

            }

        });
    </script>
@endpush
