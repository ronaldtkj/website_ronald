<?php
require 'function.php';
require 'cek.php';

// Mendapatkan id barang
$idbarang = $_GET['idbarang'];

// Ambil data barang berdasarkan id
$get = mysqli_query($conn, "SELECT * FROM barang WHERE idbarang='$idbarang'");
$fetch = mysqli_fetch_assoc($get);
$namabarang = $fetch['namabarang'];
$deskripsi = $fetch['deskripsi'];
$stock = $fetch['stock'];
$gambar = $fetch['gambar'];

// Cek gambar
if ($gambar == null || $gambar == '') {
    $img = 'docs/default.png';
} else {
    $img = 'docs/' . $gambar;
}

// Query data barang masuk
$getmasuk = mysqli_query($conn, "SELECT * FROM masuk WHERE idbarang='$idbarang'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Stock Barang</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-4">
                    <h1>Detail Barang</h1>
                    <div class="product-details">
                        <img src="<?= $img ?>" alt="<?= $namabarang ?>" style="max-width: 200px; border-radius: 5px;">
                        <h2><?= $namabarang ?></h2>
                        <p><strong>Deskripsi:</strong> <?= $deskripsi ?></p>
                        <p><strong>Stock:</strong> <?= $stock ?></p>
                    </div>

                    <h2>Barang Masuk</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>idbarang</th>
                                <th>Keterangan</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $ambilsemuadatabarang = mysqli_query($conn, "SELECT * FROM barang");
                            while ($data = mysqli_fetch_array($ambilsemuadatabarang)) {
                                $namabarang = $data['namabarang'];
                                $deskripsi = $data['deskripsi'];
                                $stock = $data['stock'];
                                $idbarang = $data['idbarang'];
                        ?>
                        <tr>
                            <td><?=$i++?></td>
                            <td><?=$idbarang?></td>
                            <td><?=$deskripsi?></td>
                            <td><?=$stock?></td>
                        </tbody>
                        <?php 
                            }
                        ?>
                    </table>
                </div>
            </main>

            <!-- Footer -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Stock Barang</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
