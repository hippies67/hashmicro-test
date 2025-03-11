@extends('layouts.index')

@section('title')
    Pegawai
@endsection

@section('css')
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
    <link href="{{ asset('style/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('style/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('style/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">

    <style>
        @media (min-width: 767.98px) {
            .dataTables_wrapper .dataTables_length {
                margin-bottom: -42px;
            }
        }

        label.error {
            color: #F94687;
            font-size: 13px;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            margin-top: 5px;
            padding: 0;
        }

        input.error {
            color: #F94687;
            border: 1px solid #F94687;
        }
    </style>
@endsection

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Pegawai</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Pegawai</h4>
                    <div class="button-list">
                        <button type="button" data-toggle="modal" data-target="#addRefPegawaiModal"
                            class="btn btn-primary btn-xs" data-animation="slide" data-plugin="custommodal"
                            data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-plus-circle mr-1"></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="pegawaiTable" class="table dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Departemen</th>
                                <th>Email</th>
                                <th>Gajih</th>
                                <th>Departemen</th>
                                <th>Total Gajih (+ Bonus)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="addRefPegawaiModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="{{ route('pegawai.store') }}" method="post" id="tambahRefPegawaiForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="col-12">
                                <label for="nama_pegawai">Nama Pegawai <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="text" id="nama_pegawai"
                                    placeholder="Masukan Nama Pegawai" name="nama_pegawai">
                                <div class="invalid-feedback" id="error_nama_pegawai"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="email" id="email"
                                placeholder="Masukan Email" name="email">
                                <div class="invalid-feedback" id="error_email"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="gajih">Gajih <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="number" id="gajih"
                                placeholder="Masukan Gajih" name="gajih">
                                <div class="invalid-feedback" id="error_gajih"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="departemen">Departemen <span class="text-danger">*</span></label>
                                <select class="form-control" name="departemen_id" id="departemen_id">
                                    <option value="">Pilih Departemen</option>
                                    @foreach($departemen as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="error_departemen_id"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="bonus_id">Bonus</label>
                                <select class="form-control" name="bonus_id" id="bonus_id">
                                    <option value="">Pilih Bonus</option>
                                    @foreach($bonus as $bon)
                                        <option value="{{ $bon->id }}">{{ $bon->nama_bonus }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="error_bonus_id"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="tambahButton">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRefPegawaiModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="{{ route('pegawai.update', '') }}" id="editRefPegawaiForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="editPegawaiId" name="pegawai_id">

                        <div class="form-group">
                            <div class="col-12">
                                <label for="edit_nama_pegawai">Nama Pegawai <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="text" id="edit_nama_pegawai"
                                    placeholder="Masukan Nama Pegawai" name="nama_pegawai">
                                <div class="invalid-feedback" id="error_edit_nama_pegawai"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="edit_email">Email <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="email" id="edit_email"
                                placeholder="Masukan Email" name="email">
                                <div class="invalid-feedback" id="error_edit_email"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="edit_gajih">Gajih <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="number" id="edit_gajih"
                                placeholder="Masukan Gajih" name="gajih">
                                <div class="invalid-feedback" id="error_edit_gajih"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="edit_departemen">Departemen <span class="text-danger">*</span></label>
                                <select class="form-control" name="departemen_id" id="edit_departemen_id">
                                    <option value="">Pilih Departemen</option>
                                    @foreach($departemen as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="error_edit_departemen_id"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="edit_bonus_id">Bonus</label>
                                <select class="form-control" name="bonus_id" id="edit_bonus_id">
                                    <option value="">Pilih Bonus</option>
                                    @foreach($bonus as $bon)
                                        <option value="{{ $bon->id }}">{{ $bon->nama_bonus }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="error_edit_bonus_id"></div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="editButton">Simpan Perubahan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('style/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('style/js/custom.min.js') }}"></script>
    <script src="{{ asset('style/js/deznav-init.js') }}"></script>

    <!-- Datatable -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('style/js/plugins-init/datatables.init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

    {{-- Sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function initializePegawaiTable() {

            $("#pegawaiTable").DataTable().destroy();

            var table = $("#pegawaiTable").DataTable({
                "order": [],
                "language": {
                    "zeroRecords": "Tidak ada data yang tersedia"
                },
                "scrollX": true,
                "dom": "Bfrtip",
                "buttons": [
                    "copy", "csv", "excel", "pdf", "print"
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('pegawai.load-data') }}",
                    "type": "GET",
                },
                columns: [{
                        data: 'increment',
                        name: 'increment'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama_pegawai'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'gajih',
                        name: 'gajih'
                    },
                    {
                        data: 'departemen',
                        name: 'departemen'
                    },
                    {
                        data: 'total_gajih',
                        name: 'total_gajih'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ]
            });

            table.on('draw.dt', function() {
                var info = table.page.info();
                var start = info.start;
                var pageLength = table.page.len();
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = start + i + 1;
                });
            });
        }

        initializePegawaiTable();
    </script>

    <script>

        function clearValidation() {
            $("#nama_pegawai").removeClass('is-invalid');
            $('#nama_pegawai').val("");
            $('#error_nama_pegawai').html("");

            $('#email').val("");
            $("#email").removeClass('is-invalid');
            $('#error_email').html("");

            $("#gajih").removeClass('is-invalid');
            $('#gajih').val("");
            $('#error_gajih').html("");

            $('#departemen_id').val("");
            $("#departemen_id").removeClass('is-invalid');
            $('#error_departemen_id').html("");

            $('#bonus_id').val("");
            $("#bonus_id").removeClass('is-invalid');
            $('#error_bonus_id').html("");

            $("#edit_nama_pegawai").val("");
            $("#edit_nama_pegawai").removeClass('is-invalid');
            $('#error_edit_nama_pegawai').html("");

            $("#edit_gajih").val("");
            $("#edit_gajih").removeClass('is-invalid');
            $('#error_edit_gajih').html("");

            $("#edit_departemen_id").val("");
            $("#edit_departemen_id").removeClass('is-invalid');
            $('#error_edit_departemen_id').html("");

            $("#edit_email").val("");
            $("#edit_email").removeClass('is-invalid');
            $('#error_edit_email').html("");

            $("#edit_bonus_id").val("");
            $("#edit_bonus_id").removeClass('is-invalid');
            $('#error_edit_bonus_id').html("");
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#tambahRefPegawaiForm').on('submit', function(e) {
            e.preventDefault();

            $("#tambahButton").prop('disabled', true);

            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('pegawai.store') }}",
                data: formData,
                success: function(response) {

                    clearValidation();

                    $("#tambahButton").prop('disabled', false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Pegawai telah berhasil ditambahkan!',
                    });

                    $('#addRefPegawaiModal').modal('hide');
                    initializePegawaiTable();
                },
                error: function(xhr) {

                    $("#tambahButton").prop('disabled', false);

                    let errors = xhr.responseJSON.errors;
                    if (errors.nama_pegawai) {
                        $('#nama_pegawai').addClass('is-invalid');
                        $('#error_nama_pegawai').text(errors.nama_pegawai[0]);
                    } else {
                        $('#nama_pegawai').removeClass('is-invalid');
                        $('#error_nama_pegawai').text("");
                    }

                    if (errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#error_email').text(errors.email[0]);
                    } else {
                        $('#email').removeClass('is-invalid');
                        $('#error_email').text("");
                    }

                    if (errors.gajih) {
                        $('#gajih').addClass('is-invalid');
                        $('#error_gajih').text(errors.gajih[0]);
                    } else {
                        $('#gajih').removeClass('is-invalid');
                        $('#error_gajih').text("");
                    }

                    if (errors.departemen_id) {
                        $('#departemen_id').addClass('is-invalid');
                        $('#error_departemen_id').text(errors.departemen_id[0]);
                    } else {
                        $('#departemen_id').removeClass('is-invalid');
                        $('#error_departemen_id').text("");
                    }

                    if (errors.bonus_id) {
                        $('#bonus_id').addClass('is-invalid');
                        $('#error_bonus_id').text(errors.bonus_id[0]);
                    } else {
                        $('#bonus_id').removeClass('is-invalid');
                        $('#error_bonus_id').text("");
                    }
                }
            });
        });

        const updateLink = $('#editRefPegawaiForm').attr('action');

        function setEditData(data) {
            $('#editRefPegawaiForm').attr('action', `${updateLink}/${data.id}`);

            $('#editPegawaiId').val(data.id);

            $('#edit_nama_pegawai').val(data.nama_pegawai);
            $('#edit_email').val(data.email);
            $('#edit_gajih').val(data.gajih);
            $('#edit_departemen_id').val(data.departemen_id);
            $('#edit_bonus_id').val(data.bonus_id);
        }

        $('#editRefPegawaiForm').on('submit', function(e) {
            e.preventDefault();

            $("#editButton").prop('disabled', true);

            let pegawaiId = $('#editPegawaiId').val();
            let formData = $(this).serialize();

            $.ajax({
                type: 'PUT',
                url: `{{ route('pegawai.update', '') }}/${pegawaiId}`,
                data: formData,
                success: function(response) {

                    clearValidation();

                    $("#editButton").prop('disabled', false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Pegawai telah berhasil diperbaharui!',
                    });

                    $('#editRefPegawaiModal').modal('hide');
                    initializePegawaiTable();
                },
                error: function(xhr) {

                    $("#editButton").prop('disabled', false);

                    let errors = xhr.responseJSON.errors;
                    if (errors.nama_pegawai) {
                        $('#edit_nama_pegawai').addClass('is-invalid');
                        $('#error_edit_nama_pegawai').text(errors.nama_pegawai[0]);
                    }

                    if (errors.email) {
                        $('#edit_email').addClass('is-invalid');
                        $('#error_edit_email').text(errors.email[0]);
                    }

                    if (errors.gajih) {
                        $('#edit_gajih').addClass('is-invalid');
                        $('#error_edit_gajih').text(errors.gajih[0]);
                    } else {
                        $('#edit_gajih').removeClass('is-invalid');
                        $('#error_edit_gajih').text("");
                    }

                    if (errors.departemen_id) {
                        $('#edit_departemen_id').addClass('is-invalid');
                        $('#error_edit_departemen_id').text(errors.departemen_id[0]);
                    } else {
                        $('#edit_departemen_id').removeClass('is-invalid');
                        $('#error_edit_departemen_id').text("");
                    }

                    if (errors.bonus_id) {
                        $('#edit_bonus_id').addClass('is-invalid');
                        $('#error_edit_bonus_id').text(errors.bonus_id[0]);
                    } else {
                        $('#edit_bonus_id').removeClass('is-invalid');
                        $('#error_edit_bonus_id').text("");
                    }

                }
            });
        });

        function deleteAlert(pegawai_id) {
            Swal.fire({
                title: "Hapus Pegawai?",
                text: `Seluruh data terkait Pegawai akan terhapus. Anda tidak akan dapat mengembalikan aksi
                ini!`,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "rgb(11, 42, 151)",
                cancelButtonColor: "rgb(209, 207, 207)",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then(function(t) {
                if (t.value) {
                    $.ajax({
                        type: 'DELETE',
                        url: `{{ route('pegawai.destroy', '') }}/${pegawai_id}`,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Pegawai telah berhasil dihapus!',
                            });

                            initializePegawaiTable();
                        }
                    });
                }
            })
        }
    </script>
@endsection
