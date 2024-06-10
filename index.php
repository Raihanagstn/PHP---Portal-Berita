<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "akademik";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$Tanggal        = "";
$Judul       = "";
$Deskripsi     = "";
$Lingkup   = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $Tanggal        = $r1['Tanggal'];
    $Judul       = $r1['Judul'];
    $Deskripsi     = $r1['Deskripsi'];
    $Lingkup   = $r1['Lingkup'];

    if ($Tanggal == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $Tanggal        = $_POST['Tanggal'];
    $Judul       = $_POST['Judul'];
    $Deskripsi     = $_POST['Deskripsi'];
    $Lingkup   = $_POST['Lingkup'];

    if ($Tanggal && $Judul && $Deskripsi && $Lingkup) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update mahasiswa set Tanggal = '$Tanggal',Judul='$Judul',Deskripsi = '$Deskripsi',Lingkup='$Lingkup' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into mahasiswa(Tanggal,Judul,Deskripsi,Lingkup) values ('$Tanggal','$Judul','$Deskripsi','$Lingkup')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .website-title {
            font-size: 2em;
            color: #007bff;
            margin-bottom: 20px;
            text-shadow: 2px 2px #000000;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- Header nama website -->
        <div class="card">
            <div class="card-header text-center bold bg-dark  text-center website-title">
                FOOTBALL NEWS MANIA
            </div>
        </div>
        <!-- Header pertama -->
        <div class="card">
            <div class="card-header text-center bold">
                PORTAL BERITA OLEH MUHAMAD RAIHAN AGUSTIAN (2101302) - UJIAN AKHIR SEMESTER MATA KULIAH APLIKASI TEKNOLOGI JARINGAN
            </div>
        </div>
        <!-- Header kedua -->
        <div class="card">
            <div class="card-header bg-secondary text-white text-center bold">
                Buat dan Tambahkan Berita
            </div>
        </div>
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="Tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Tanggal" name="Tanggal" value="<?php echo $Tanggal ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Judul" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Judul" name="Judul" value="<?php echo $Judul ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Deskripsi" name="Deskripsi" value="<?php echo $Deskripsi ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Lingkup" class="col-sm-2 col-form-label">Lingkup</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Lingkup" id="Lingkup">
                                <option value="">- Pilih Lingkup -</option>
                                <option value="Nasional" <?php if ($Lingkup == "Nasional") echo "selected" ?>>Nasional</option>
                                <option value="Internasional" <?php if ($Lingkup == "Internasional") echo "selected" ?>>Internasional</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Berita" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white text text-center bold  bg-secondary">
                Daftar Berita
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Lingkup</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from mahasiswa order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $Tanggal        = $r2['Tanggal'];
                            $Judul       = $r2['Judul'];
                            $Deskripsi     = $r2['Deskripsi'];
                            $Lingkup   = $r2['Lingkup'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $Tanggal ?></td>
                                <td scope="row"><?php echo $Judul ?></td>
                                <td scope="row"><?php echo $Deskripsi ?></td>
                                <td scope="row"><?php echo $Lingkup ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>
