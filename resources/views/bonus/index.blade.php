@extends('layouts.index')

@section('title')
    Referensi Bonus
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
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Referensi Bonus</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Referensi Bonus</h4>
                    <div class="button-list">
                        <button type="button" data-toggle="modal" data-target="#addRefBonusModal"
                            class="btn btn-primary btn-xs" data-animation="slide" data-plugin="custommodal"
                            data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-plus-circle mr-1"></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="bonusTable" class="table dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Bonus</th>
                                <th>Jumlah Bonus</th>
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
    <div class="modal fade" id="addRefBonusModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="{{ route('bonus.store') }}" method="post" id="tambahRefBonusForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Referensi Bonus</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="col-12">
                                <label for="nama_bonus">Nama Bonus <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="text" id="nama_bonus"
                                    placeholder="Masukan Nama Bonus" name="nama_bonus" value="{{ old('nama_bonus') }}">
                                <div class="invalid-feedback" id="error_nama_bonus"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="number" id="jumlah"
                                    placeholder="Masukan Jumlah Bonus" name="jumlah" value="{{ old('jumlah') }}">
                                <div class="invalid-feedback" id="error_jumlah"></div>
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

    <div class="modal fade" id="editRefBonusModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="{{ route('bonus.update', '') }}" id="editRefBonusForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Referensi Bonus</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="editBonusId" name="bonus_id">

                        <div class="form-group">
                            <div class="col-12">
                                <label for="edit_nama_bonus">Nama Bonus <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="text" id="edit_nama_bonus"
                                    placeholder="Masukan Nama Bonus" name="nama_bonus"
                                    value="{{ old('edit_nama_bonus') }}">
                                <div class="invalid-feedback" id="error_edit_nama_bonus"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="edit_jumlah">Jumlah <span class="text-danger">*</span></label>
                                <input class="form-control mb-1" type="number" id="edit_jumlah"
                                    placeholder="Masukan Jumlah Bonus" name="jumlah"
                                    value="{{ old('edit_jumlah') }}">
                                <div class="invalid-feedback" id="error_edit_jumlah"></div>
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
        function initializeBonusTable() {

            $("#bonusTable").DataTable().destroy();

            var table = $("#bonusTable").DataTable({
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
                    "url": "{{ route('bonus.load-data') }}",
                    "type": "GET",
                },
                columns: [{
                        data: 'increment',
                        name: 'increment'
                    },
                    {
                        data: 'nama_bonus',
                        name: 'nama_bonus'
                    },
                    {
                        data: 'jumlah_bonus',
                        name: 'jumlah_bonus'
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

        initializeBonusTable();
    </script>

    <script>

        function clearValidation() {
            $("#nama_bonus").removeClass('is-invalid');
            $("#jumlah").removeClass('is-invalid');
            $('#nama_bonus').val("");
            $('#jumlah').val("");
            $('#error_nama_bonus').html("");
            $('#error_jumlah').html("");

            $("#edit_nama_bonus").val("");
            $("#edit_jumlah").val("");
            $("#edit_nama_bonus").removeClass('is-invalid');
            $("#edit_jumlah").removeClass('is-invalid');
            $('#error_edit_nama_bonus').html("");
            $('#error_edit_jumlah').html("");
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#tambahRefBonusForm').on('submit', function(e) {
            e.preventDefault();

            $("#tambahButton").prop('disabled', true);

            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('bonus.store') }}",
                data: formData,
                success: function(response) {

                    clearValidation();

                    $("#tambahButton").prop('disabled', false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Referensi Bonus telah berhasil ditambahkan!',
                    });

                    $('#addRefBonusModal').modal('hide');
                    initializeBonusTable();
                },
                error: function(xhr) {

                    $("#tambahButton").prop('disabled', false);

                    let errors = xhr.responseJSON.errors;
                    if (errors.nama_bonus) {
                        $('#nama_bonus').addClass('is-invalid');
                        $('#error_nama_bonus').text(errors.nama_bonus[0]);
                    } else {
                        $('#nama_bonus').removeClass('is-invalid');
                        $('#error_nama_bonus').text("");
                    }

                    if (errors.jumlah) {
                        $('#jumlah').addClass('is-invalid');
                        $('#error_jumlah').text(errors.jumlah[0]);
                    } else {
                        $('#jumlah').removeClass('is-invalid');
                        $('#error_jumlah').text("");
                    }
                }
            });
        });

        const updateLink = $('#editRefBonusForm').attr('action');

        function setEditData(data) {
            $('#editRefBonusForm').attr('action', `${updateLink}/${data.id}`);

            $('#editBonusId').val(data.id);

            $('#edit_nama_bonus').val(data.nama_bonus);
            $('#edit_jumlah').val(data.jumlah);
        }

        $('#editRefBonusForm').on('submit', function(e) {
            e.preventDefault();

            $("#editButton").prop('disabled', true);

            let bonusId = $('#editBonusId').val();
            let formData = $(this).serialize();

            $.ajax({
                type: 'PUT',
                url: `{{ route('bonus.update', '') }}/${bonusId}`,
                data: formData,
                success: function(response) {

                    clearValidation();

                    $("#editButton").prop('disabled', false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Referensi Bonus telah berhasil diperbaharui!',
                    });

                    $('#editRefBonusModal').modal('hide');
                    initializeBonusTable();
                },
                error: function(xhr) {

                    $("#editButton").prop('disabled', false);

                    let errors = xhr.responseJSON.errors;
                    if (errors.nama_bonus) {
                        $('#edit_nama_bonus').addClass('is-invalid');
                        $('#error_edit_nama_bonus').text(errors.nama_bonus[0]);
                    }
                    if (errors.jumlah) {
                        $('#edit_jumlah').addClass('is-invalid');
                        $('#error_edit_jumlah').text(errors.jumlah[0]);
                    }
                }
            });
        });

        function deleteAlert(bonus_id) {
            Swal.fire({
                title: "Hapus Referensi Bonus?",
                text: `Seluruh data terkait referensi bonus akan terhapus. Anda tidak akan dapat mengembalikan aksi
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
                        url: `{{ route('bonus.destroy', '') }}/${bonus_id}`,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Referensi Bonus telah berhasil dihapus!',
                            });

                            initializeBonusTable();
                        }
                    });
                }
            })
        }
    </script>
@endsection
