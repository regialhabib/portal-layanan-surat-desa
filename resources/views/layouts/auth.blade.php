<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Portal Pelayanan Desa Lubuk Bernai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Portal Pelayanan dan Informasi Desa Lubuk Bernai" name="description" />
    <meta content="Pemerintah Desa Lubuk Bernai" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/sekolah.png') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

@stack('style')
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    @yield('main-content')
                    

                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>