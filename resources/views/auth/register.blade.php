
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Pengguna</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center"><a href="{{ url('/') }}" class="h1"><b>Kompen</b></a></div>
            <div class="card-body">
                <p class="login-box-msg">Sign up to start your session</p>
                <form action="{{ url('register') }}" method="POST" id="form-register">
                    @csrf
                    <div class="form-group">
                        <label>Level Pengguna</label>
                        <input name="level_id" id="level_id" class="form-control" disabled value="--Mahasiswa--">
                    </input>
                        <small id="error-level_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input value="" type="text" name="username" id="username" class="form-control"
                            required>
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Mahasiswa</label>
                        <input value="" type="text" name="mahasiswa_nama" id="mahasiswa_nama" class="form-control"
                            required>
                        <small id="error-nama" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>NIM</label>
                        <input value="" type="text" name="nim" id="nim" class="form-control"
                            required>
                        <small id="error-nim" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>No Telp</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control"
                            required>
                        <small id="error-no_telp" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jurusan</label>
                        <select name="jurusan" id="jurusan" class="form-control"
                            required> 
                            <option value="" selected>--Select--</option>
                            <option value="Teknologi Informasi">Teknologi Informasi</option>
                        </select>
                        <small id="error-jurusan" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Prodi</label>
                        <select name="prodi" id="prodi" class="form-control"
                            required> 
                            <option value="" selected>--Select--</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Sistem Informasi Bisnis">Sistem Informasi Bisnis</option>
                        </select>
                        <small id="error-prodi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input value="" type="text" name="kelas" id="kelas" class="form-control" placeholder="contoh: 3B, 1A"
                            required> 
                        <small id="error-kelas" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input value="" type="password" name="password" id="password" class="form-control"
                            required>
                        <small id="error-password" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $("#form-register").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    mahasiswa_nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    nim: {
                        required: true,
                        minlength: 3,
                        maxlength: 20,
                        number: true
                    },
                    no_telp: {
                        required: true,
                        number: true,
                        minlength: 9,
                        maxlength: 20
                    },
                    jurusan: {
                        required: true,
                    },
                    prodi: {
                        required: true,
                    },
                    kelas: {
                        required: true,
                        minlength: 2,
                        maxlength: 2
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    }
                },
                submitHandler: function(form) { // ketika valid, maka bagian yg akan dijalankan
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) { // jika sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(function() {
                                    window.location = response.redirect;
                                });
                            } else { // jika error
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>