@extends('layouts.main')

@push('style')
    <!-- DataTables -->
    <link href="{{ URL::asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Sweet Alert-->
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('main-content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-block-helper me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                                <i class="mdi mdi-block-helper me-2"></i>
                                {{ $error }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif


                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Laporan Surat</h6>
                        </div>

                        <div class="card-body">
                            <form id="formFilter">
                                <div class="row align-items-end g-3">

                                    <!-- Tanggal Awal -->
                                    <div class="col-md-3">
                                        <label class="form-label">Tanggal Awal</label>
                                        <input type="date" id="tanggal_awal" class="form-control" required>
                                    </div>

                                    <!-- Tanggal Akhir -->
                                    <div class="col-md-3">
                                        <label class="form-label">Tanggal Akhir</label>
                                        <input type="date" id="tanggal_akhir" class="form-control" required>
                                    </div>

                                    <!-- Jenis Surat -->
                                    <div class="col-md-3">
                                        <label class="form-label">Jenis Surat</label>
                                        <select name="jenis_surat" id="jenis_surat" class="form-control">
                                            <option value="surat_masuk">Surat Masuk</option>
                                            <option value="surat_keluar">Surat Keluar</option>
                                        </select>
                                    </div>

                                    <!-- Tombol -->
                                    <div class="col-md-3 d-flex gap-2">
                                        <button class="btn btn-primary w-100" type="submit">
                                            <i class="fas fa-search"></i> Tampilkan
                                        </button>

                                        <a href="#" id="btnPrint" class="btn btn-danger w-100 d-none"
                                            target="_blank">
                                            <i class="fas fa-file-pdf"></i> Unduh
                                        </a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 50px;" class="text-center">No</th>
                                <th>No Surat</th>
                                <th>Tanggal Diterima/Kirim</th>
                                <th>Pengirim/Penerima</th>
                                <th>Perihal</th>
                                <th>Keterangan</th>
                                <th>File Surat</th>
                            </tr>
                        </thead>


                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


    <!--  Form Delete -->
    <form id="form-delete" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>


@endsection

@push('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->


    <!-- Sweet Alerts js -->
    <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        let table;

        $(document).ready(function() {

            table = $('#datatable').DataTable({
                processing: true,
                serverSide: false,
                searching: false,
                ordering: false,
                paging: true,
                info: true,
                data: [], // kosong saat awal
                language: {
                    emptyTable: "Silakan isi filter tanggal terlebih dahulu"
                },
                columns: [{
                        data: null
                    },

                    {
                        data: 'no_surat'
                    },

                    {
                        data: 'tanggal_terima'
                    },
                    {
                        data: 'alamat_penerima'
                    },
                    {
                        data: 'isi_surat'
                    },
                    {
                        data: 'keterangan'
                    }, {
                        data: 'surat'
                    }
                ],
                columnDefs: [{
                    targets: 0,
                    render: (data, type, row, meta) => meta.row + 1
                }]
            });


            $('#formFilter').on('submit', function(e) {
                e.preventDefault();

                let awal = $('#tanggal_awal').val();
                let akhir = $('#tanggal_akhir').val();
                let jenis = $('#jenis_surat').val();

                $.ajax({
                    url: "{{ route('laporan.data') }}",
                    type: "GET",
                    data: {
                        tanggal_awal: awal,
                        tanggal_akhir: akhir,
                        jenis_surat: jenis
                    },
                    success: function(res) {

                        table.clear().rows.add(res.data).draw();

                        $('#btnPrint')
                            .removeClass('d-none')
                            .attr('href',
                                "{{ route('laporan.print') }}?tanggal_awal=" +
                                awal + "&tanggal_akhir=" + akhir + "&jenis_surat=" + jenis
                            );
                    }
                });
            });
        });
    </script>
@endpush
