<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">


</head>
<body>
    <!-- Navigation -->
    <nav class="nav nav-pills nav-fill px-4 pt-2">
        <button class="nav-link active" id="scholarship-tab" data-bs-toggle="tab" data-bs-target="#scholarship" type="button" role="tab" aria-controls="scholarship" aria-selected="true">Home</button>
        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Daftar</button>
        <button class="nav-link" id="result-tab" data-bs-toggle="tab" data-bs-target="#result" type="button" role="tab" aria-controls="result" aria-selected="false" onclick="fillTableData()">Hasil</button>
    </nav>
    <!-- End of Navigation -->
    <hr class="mx-5 d-block" style="border-width : 10px; border-radius : 10px;">
    
    <!-- Tab Page -->
    <div class="tab-content">
        <!-- Scholarship Option -->
        <div class="tab-pane fade show active" id="scholarship" role="tabpanel" aria-labelledby="scholarship-options-tab" tabindex="0">        
            <div class="d-flex flex-row justify-content-center">
                <button class="btn btn-primary mx-2 scholarships-buttons" type="button">Akademik</button>
                <button class="btn btn-success mx-2 scholarships-buttons" type="button">Non Akakdemik</button>
            </div>
        </div>
        <!-- End of Scholarship Option -->
        <!-- Register -->
        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab" tabindex="0">
            <div class="mx-auto" style="width:60%;">
                <h1 class="text-center">Daftar Beasiswa</h1>
                <div class="card">
                    <div class="card-header">
                        Registrasi Beasiswa
                    </div>
                    <div class="card-body">
                        <form method="post" action="#" id="register-form">
                            <div class="mb-3 row">
                                <label for="name-field" class="col-sm-4 col-form-label">Masukkan Nama</label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name-field" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="email-field" class="col-sm-4 col-form-label">Masukkan Email</label>
                                <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" id="email-field" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="no-field" class="col-sm-4 col-form-label">Nomor HP</label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" name="phoneNumber" id="no-field" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="semester-field" class="col-sm-4 col-form-label">Semester Saat Ini</label>
                                <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example" name="semester" id="semester-field" required>
                                    <option selected>Pilih</option>
                                    <?php for ($i = 1; $i <= 8; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="ipk-field" class="col-sm-4 col-form-label">IPK Terakhir</label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" name="gpa" id="ipk-field" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="beasiswa-field" class="col-sm-4 col-form-label">Pilihan Beasiswa</label>
                                <div class="col-sm-8">
                                <select class="form-select" id="beasiswa-field" name="scholarship" aria-label="Default select example" required>
                                    <option selected>Pilih</option>
                                    <option value="Akademik">Akademik</option>
                                    <option value="Non-Akademik">Non Akademik</option>
                                </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="file-field" class="col-sm-4 col-form-label">Upload Berkas Syarat</label>
                                <div class="col-sm-8">
                                    <div class="btn btn-primary" id="upload">
                                        <label for="file-field">Upload</label>
                                        <input type="file" id="file-field" name="file" class="d-none" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-evenly mt-5">
                                <button type="submit" id="daftar" class="btn btn-primary btn-lg px-5">Daftar</button>
                                <button type="button" id="cancel" class="btn btn-secondary btn-lg px-5">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>   
        </div>
        <!-- End of Register -->
        <div class="tab-pane fade" id="result" role="tabpanel" aria-labelledby="result-tab" tabindex="0">
            <div class="text-center">            
                <div class="spinner-border " role="status" id="table-loading">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <table id="table-data" class="table table-hover d-none">
                <thead>
                    <tr>
                        <th >ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Semester</th>
                        <th>IPK</th>
                        <th>Beasiswa</th> 
                        <th>File</th>
                        <th>Status Ajuan</th>                 
                    </tr>
                </thead>
                <tbody id="table-result">

                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>