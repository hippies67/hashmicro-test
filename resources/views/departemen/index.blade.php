@extends('layouts.index')

@section('title')
    Referensi Departemen
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
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Referensi Departemen</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Referensi Departemen</h4>
                    <div class="button-list">
                        <button type="button" data-toggle="modal" data-target="#addRefDepartemenModal"
                            class="btn btn-primary btn-xs" data-animation="slide" data-plugin="custommodal"
                            data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-plus-circle mr-1"></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="departemenTable" class="table dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Departemen</th>
                                <th>Deskripsi</th>
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
    <div class="modal fade" id="addRefDepartemenModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="{{ route('departemen.store') }}" method="post" id="tambahRefDepartemenForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Referensi Departemen</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="col-12">
                                <label for="nama_departemen">Nama Departemen <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="text" id="nama_departemen"
                                    placeholder="Masukan Nama Departemen" name="nama_departemen" value="{{ old('nama_departemen') }}">
                                <div class="invalid-feedback" id="error_nama_departemen"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea>
                                <div class="invalid-feedback" id="error_deskripsi"></div>
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

    <div class="modal fade" id="editRefDepartemenModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="{{ route('departemen.update', '') }}" id="editRefDepartemenForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Referensi Departemen</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="editDepartemenId" name="departemen_id">

                        <div class="form-group">
                            <div class="col-12">
                                <label for="edit_nama_departemen">Nama Departemen <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="text" id="edit_nama_departemen"
                                    placeholder="Masukan Nama Departemen" name="nama_departemen"
                                    value="{{ old('edit_nama_departemen') }}">
                                <div class="invalid-feedback" id="error_edit_nama_departemen"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="edit_deskripsi">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" cols="30" rows="10"></textarea>
                                <div class="invalid-feedback" id="error_edit_deskripsi"></div>
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
        function initializeDepartemenTable() {

            $("#departemenTable").DataTable().destroy();

            var table = $("#departemenTable").DataTable({
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
                    "url": "{{ route('departemen.load-data') }}",
                    "type": "GET",
                },
                columns: [{
                        data: 'increment',
                        name: 'increment'
                    },
                    {
                        data: 'nama_departemen',
                        name: 'nama_departemen'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
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

        initializeDepartemenTable();
    </script>

    <script>

        function clearValidation() {
            $("#nama_departemen").removeClass('is-invalid');
            $("#deskripsi").removeClass('is-invalid');
            $('#nama_departemen').val("");
            $('#deskripsi').val("");
            $('#error_nama_departemen').html("");
            $('#error_deskripsi').html("");

            $("#edit_nama_departemen").val("");
            $("#edit_deskripsi").val("");
            $("#edit_nama_departemen").removeClass('is-invalid');
            $("#edit_deskripsi").removeClass('is-invalid');
            $('#error_edit_nama_departemen').html("");
            $('#error_edit_deskripsi').html("");
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#tambahRefDepartemenForm').on('submit', function(e) {
            e.preventDefault();

            $("#tambahButton").prop('disabled', true);

            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('departemen.store') }}",
                data: formData,
                success: function(response) {

                    clearValidation();

                    $("#tambahButton").prop('disabled', false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Referensi Departemen telah berhasil ditambahkan!',
                    });

                    $('#addRefDepartemenModal').modal('hide');
                    initializeDepartemenTable();
                },
                error: function(xhr) {

                    $("#tambahButton").prop('disabled', false);

                    let errors = xhr.responseJSON.errors;
                    if (errors.nama_departemen) {
                        $('#nama_departemen').addClass('is-invalid');
                        $('#error_nama_departemen').text(errors.nama_departemen[0]);
                    } else {
                        $('#nama_departemen').removeClass('is-invalid');
                        $('#error_nama_departemen').text("");
                    }

                    if (errors.deskripsi) {
                        $('#deskripsi').addClass('is-invalid');
                        $('#error_deskripsi').text(errors.deskripsi[0]);
                    } else {
                        $('#deskripsi').removeClass('is-invalid');
                        $('#error_deskripsi').text("");
                    }
                }
            });
        });

        const updateLink = $('#editRefDepartemenForm').attr('action');

        function setEditData(data) {
            $('#editRefDepartemenForm').attr('action', `${updateLink}/${data.id}`);

            $('#editDepartemenId').val(data.id);

            $('#edit_nama_departemen').val(data.nama_departemen);
            $('#edit_deskripsi').val(data.deskripsi);
        }

        $('#editRefDepartemenForm').on('submit', function(e) {
            e.preventDefault();

            $("#editButton").prop('disabled', true);

            let departemenId = $('#editDepartemenId').val();
            let formData = $(this).serialize();

            $.ajax({
                type: 'PUT',
                url: `{{ route('departemen.update', '') }}/${departemenId}`,
                data: formData,
                success: function(response) {

                    clearValidation();

                    $("#editButton").prop('disabled', false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Referensi Departemen telah berhasil diperbaharui!',
                    });

                    $('#editRefDepartemenModal').modal('hide');
                    initializeDepartemenTable();
                },
                error: function(xhr) {

                    $("#editButton").prop('disabled', false);

                    let errors = xhr.responseJSON.errors;
                    if (errors.nama_departemen) {
                        $('#edit_nama_departemen').addClass('is-invalid');
                        $('#error_edit_nama_departemen').text(errors.nama_departemen[0]);
                    }
                    if (errors.deskripsi) {
                        $('#edit_deskripsi').addClass('is-invalid');
                        $('#error_edit_deskripsi').text(errors.deskripsi[0]);
                    }
                }
            });
        });

        function deleteAlert(departemen_id) {
            Swal.fire({
                title: "Hapus Referensi Departemen?",
                text: `Seluruh data terkait referensi departemen akan terhapus. Anda tidak akan dapat mengembalikan aksi
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
                        url: `{{ route('departemen.destroy', '') }}/${departemen_id}`,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Referensi Departemen telah berhasil dihapus!',
                            });

                            initializeDepartemenTable();
                        }
                    });
                }
            })
        }
    </script>
@endsection
