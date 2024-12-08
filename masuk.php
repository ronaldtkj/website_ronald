<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Stock Barang</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
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
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Masuk
                        </a> 
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Keluar
                        </a> 
                        <a class="nav-link" href="logout.php">Logout</a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Barang Masuk</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Barang</button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th><center>ID Masuk</center></th>
                                        <th>Nama Barang</th>
                                        <th>gambar<th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Quantity</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * from masuk m, barang s where s.idbarang=m.idbarang");
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $idbarang = $data['idbarang'];
                                            $idmasuk = $data['idmasuk'];
                                            $namabarang = $data['namabarang'];
                                            $gambar = $data['gambar'];
                                            $tanggal = $data['tanggal'];
                                            $keterangan = $data['keterangan'];
                                            $qty = $data['qty'];
                                    ?>
                                    <tr>
                                        <td><center><?=$idmasuk;?></center></td>
                                        <td><?=$namabarang;?></td>
                                        <td><img src="docs/<?=$gambar?>" width="100"></td>
                                        <td><?=$tanggal;?></td>
                                        <td><?=$keterangan;?></td>
                                        <td><?=$qty;?></td>
                                        <td>
                                            <!-- Tombol Delete -->
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusbarang<?=$idmasuk;?>">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Modal hapus Barang -->
                                    <div class="modal fade" id="hapusbarang<?=$idmasuk;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="hapus">Hapus Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post" action="delete.php" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus barang: <?=$namabarang;?>?
                                                        <input type="hidden" name="idbarang" value="<?=$idbarang;?>">
                                                        <input type="hidden" name="qty" value="<?=$qty;?>">
                                                        <input type="hidden" name="idmasuk" value="<?=$idmasuk;?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="hapusBarangmasuk">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Stock Barang 2024</div>
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
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="function.php">
                <div class="modal-body">
                    <select name="idbarang" class="form-control mb-3">
                        <option selected>Pilih Barang</option>
                        <?php 
                            $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM barang");
                            while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                $namabarang = $fetcharray['namabarang'];
                                $idbarang = $fetcharray['idbarang'];
                        ?>
                        <option value="<?=$idbarang;?>"><?=$namabarang;?></option>
                        <?php
                            }
                        ?>
                    </select>
                    
                    <input class="form-control mb-3" type="text" name="qty" placeholder="Quantity" required>
                    <input class="form-control mb-3" type="text" name="keterangan" placeholder="Keterangan" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="barangmasuk">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>
