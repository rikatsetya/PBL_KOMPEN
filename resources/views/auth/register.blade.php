<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Pengguna</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow border-0">
                    <div class="card-header text-center bg-primary text-white">
                        {{-- <h3 class="mb-0">Register Pengguna</h3> --}}
                        <a href="{{ url('/') }}" class="h1" style="text-decoration: none"><b>Kompen</b></a>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('register') }}" method="POST" id="form-register">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Level Pengguna</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input name="level_id" id="level_id" class="form-control" disabled value="--Mahasiswa--">
                                    </div>
                                    <small id="error-level_id" class="text-danger"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" name="username" id="username" class="form-control" required>
                                    </div>
                                    <small id="error-username" class="text-danger"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Mahasiswa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="text" name="mahasiswa_nama" id="mahasiswa_nama" class="form-control" required>
                                    </div>
                                    <small id="error-nama" class="text-danger"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIM</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                        <input type="text" name="nim" id="nim" class="form-control" required>
                                    </div>
                                    <small id="error-nim" class="text-danger"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No Telp</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" name="no_telp" id="no_telp" class="form-control" required>
                                    </div>
                                    <small id="error-no_telp" class="text-danger"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jurusan</label>
                                    <select name="jurusan" id="jurusan" class="form-select" required>
                                        <option value="" selected>--Select--</option>
                                        <option value="Teknologi Informasi">Teknologi Informasi</option>
                                    </select>
                                    <small id="error-jurusan" class="text-danger"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Prodi</label>
                                    <select name="prodi" id="prodi" class="form-select" required>
                                        <option value="" selected>--Select--</option>
                                        <option value="Teknik Informatika">Teknik Informatika</option>
                                        <option value="Sistem Informasi Bisnis">Sistem Informasi Bisnis</option>
                                    </select>
                                    <small id="error-prodi" class="text-danger"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kelas</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                                        <input type="text" name="kelas" id="kelas" class="form-control" placeholder="contoh: 3B, 1A" required>
                                    </div>
                                    <small id="error-kelas" class="text-danger"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                    </div>
                                    <small id="error-password" class="text-danger"></small>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
