<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "rentcar";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nama        = "";
$tanggal       = "";
$tujuan     = "";
$jenis_mobil   = "";
$sukses     = "";
$error      = "";
$op = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id_penyewa'];
    $sql1       = "delete from penyewa where id_penyewa = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id_penyewa'];
    $sql1       = "select * from penyewa where id_penyewa = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama        = $r1['nama_penyewa'];
    $tanggal       = $r1['tanggal'];
    $tujuan     = $r1['tujuan'];
    $jenis_mobil   = $r1['jenis_mobil'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nama        = $_POST['nama_penyewa'];
    $tanggal       = $_POST['tanggal'];
    $tujuan     = $_POST['tujuan'];
    $jenis_mobil   = $_POST['jenis_mobil'];

    if ($nama && $tanggal && $tujuan && $jenis_mobil) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update penyewa set nama_penyewa = '$nama',tanggal='$tanggal',tujuan = '$tujuan',jenis_mobil='$jenis_mobil' where id_penyewa = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into penyewa(nama_penyewa,tanggal,tujuan,jenis_mobil) values ('$nama','$tanggal','$tujuan','$jenis_mobil')";
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
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentCar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#">Rent-Car</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Admin Elements
                    </li>
                    <li class="sidebar-item">
                        <a href="index.php" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="mobil.php" class="sidebar-link">
                            <i class="fa-solid fa-car pe-2"></i>
                            Mobil
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="tambah_data.php" class="sidebar-link">
                            <i class="fa-solid fa-plus pe-2"></i>
                            Tambah Data
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="data.php" class="sidebar-link">
                            <i class="fa-solid fa-database pe-2"></i>
                            Data
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#auth" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-regular fa-user pe-2"></i>
                            Auth
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Login</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Register</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Forgot Password</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="image/profile.jpg" class="avatar img-fluid rounded" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Setting</a>
                                <a href="#" class="dropdown-item">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Tambah Data</h4>
                    </div>
                    <!-- untuk memasukkan data -->
                    <div class="card">
                        <div class="card-header text-white bg-secondary">
                            Create / Edit Data
                        </div>
                        <div class="card-body">
                            <?php
                            if ($error) {
                            ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error ?>
                                        </div>
                                        <?php
                                header("refresh:5;url=tambah_data.php");//5 : detik
                            }
                            ?>
                                        <?php
                            if ($sukses) {
                            ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $sukses ?>
                                        </div>
                                        <?php
                                header("refresh:5;url=tambah_data.php");
                            }
                            ?>
                            <form action="" method="POST">
                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama" name="nama_penyewa"
                                            value="<?php echo $nama ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="tanggal" class="col-sm-2 col-form-label">tanggal</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                                            value="<?php echo $tanggal ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="tujuan" class="col-sm-2 col-form-label">tujuan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="tujuan" name="tujuan"
                                            value="<?php echo $tujuan ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="jenis_mobil" class="col-sm-2 col-form-label">jenis mobil</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="jenis_mobil" id="jenis_mobil">
                                            <option value=""></option>
                                            <option value="avanza"
                                                <?php if ($jenis_mobil == "avanza") echo "selected" ?>>
                                                Avanza
                                            </option>
                                            <option value="ertiga"
                                                <?php if ($jenis_mobil == "ertiga") echo "selected" ?>>
                                                Ertiga
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" class="text-muted">
                                    <strong>Rent-Car</strong>
                                </a>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Contact</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">About Us</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Terms</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Booking</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>