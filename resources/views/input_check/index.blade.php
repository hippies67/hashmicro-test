@extends('layouts.index')

@section('title')
    Dashboard
@endsection

@section('css')
    <link href="{{ asset('style/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('style/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('style/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Pengecekan Input Karakter</h4>
                </div>
                <div class="card-body">
                    <form id="pengecekanInputKarakter">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Input 1</label>
                                    <input type="text" name="input_1" class="form-control" placeholder="Masukkan Input 1">
                                    <small class="text-danger mt-2" id="input_1_validation"></small>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Input 2</label>
                                    <input type="text" name="input_2" class="form-control" placeholder="Masukkan Input 2">
                                    <small class="text-danger mt-2" id="input_2_validation"></small>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Karakter</label>
                                    <select name="type" class="form-control" id="">
                                        <option value="1">Abaikan Case Sensitive</option>
                                        <option value="2">Gunakan Case Sensitive</option>
                                    </select>
                                    <small class="text-danger mt-2" id="type_validation"></small>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary" id="submitButton" style="margin-top: 30px;"><i class="bi bi-percent mr-1"></i> Dapatkan Hasil</button>
                            </div>
                        </div>
                    </form>
                    <div class="row" id="hasilWrap" style="display: none;">
                        <div class="col-sm-12">
                            <div class="alert alert-primary" role="alert">
                                <h5 style="border-bottom: 1px solid #bf1e2e; padding-bottom: 5px;">Hasil :</h5>
                                <b id="hasilPersentase"></b><br>
                                <p id="hasilKalkulasi" style="margin-bottom: 0px;"></p>
                              </div>
                        </div>
                    </div>
                    <div class="row" id="emptyStateWrap">
                        <div class="col-sm-12">
                            <div class="alert alert-primary" role="alert">
                                <h5 style="border-bottom: 1px solid #bf1e2e; padding-bottom: 5px;">Hasil :</h5>
                                <p id="hasilKalkulasi" style="margin-bottom: 0px;">Harap isi <b>Input 1</b> dan <b>Input 2</b> untuk mendapatkan hasil.</p>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('style/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('style/js/custom.min.js') }}"></script>
    <script src="{{ asset('style/js/deznav-init.js') }}"></script>
    <script src="{{ asset('style/vendor/owl-carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('style/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('style/vendor/peity/jquery.peity.min.js') }}"></script>

    <script>
        function resetValidation() {
            const validation = document.querySelectorAll(`[id$="_validation"]`);
            for (let i = 0; i < validation.length; i++) {
                validation[i].style.display = "none";
                validation[i].previousElementSibling.style.borderColor = "";
            }
        }

        let pengencekanInput = document.getElementById('pengecekanInputKarakter');

        pengencekanInput.addEventListener('submit', (e) => {
            e.preventDefault();

            var submitButton = document.getElementById('submitButton');
            submitButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memproses';
            submitButton.disabled = true;

            let input_1 = pengencekanInput.input_1.value;
            let input_2 = pengencekanInput.input_2.value;
            let type = pengencekanInput.type.value;

            let formData = new FormData();
            formData.append('input_1', input_1);
            formData.append('input_2', input_2);
            formData.append('type', type);

            fetch("{{ route('input-check.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(resp => {
                    if (resp.status === true) {

                        submitButton.innerHTML = '<i class="bi bi-percent mr-1"></i> Dapatkan Hasil';
                        submitButton.disabled = false;

                        document.getElementById('emptyStateWrap').style.display = 'none';
                        document.getElementById('hasilWrap').style.display = 'flex';
                        if (resp.data.char.length > 0) {
                            resetValidation();
                            document.getElementById('hasilKalkulasi').style.display = 'block';
                            document.getElementById('hasilKalkulasi').innerHTML = 'Dikarenakan terdapat karakter ' + '<b>' + resp.data.char + '</b>' + ' di <b>' + 'Input 2' + '</b>.';
                        } else {
                            document.getElementById('hasilKalkulasi').style.display = 'none';
                        }
                        document.getElementById('hasilPersentase').textContent = resp.data.result + '%';
                    } else {

                        submitButton.innerHTML = '<i class="bi bi-percent mr-1"></i> Dapatkan Hasil';
                        submitButton.disabled = false;

                        document.getElementById('hasilWrap').style.display = 'none';
                        document.getElementById('emptyStateWrap').style.display = 'flex';
                        if (resp.data) {
                            let error = Object.entries(resp.data);
                            resetValidation();
                            error.forEach(([key, value]) => {
                                let validationElement = document.getElementById(key + '_validation');
                                validationElement.style.display = 'block';
                                validationElement.textContent = value;
                                validationElement.previousElementSibling.style.borderColor = "red";
                            });
                        }
                    }
                });
        });
    </script>
@endsection
