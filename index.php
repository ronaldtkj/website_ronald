<?php
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
    <title>Stock Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        a{
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Stock Barang</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <<div id="layoutSidenav">
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Stock Barang</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Tambah Stock
                            </button>
                            <a href="exportbarang.php" target="_blank" class="btn btn-success"> <i class="ti ti-printer"><i>Export Barang</a>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                <tr>
                                    <th>ID Barang </th>
                                    <th>Nama Barang</th>
                                    <th>Gambar</th>
                                    <th>Deskripsi</th>
                                    <th>Stock</th>
                                    <th>Aksi</th>
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
                                            $gambar = $data['gambar'];
                                    ?>
                                    <tr>
                                        <td><?=$i++?></td>
                                        <td><?=$namabarang?></td>
                                        <td><img src="docs/<?=$gambar?>" alt="gambar" width="80"></td>
                                        <td><strong><a href="detail.php?idbarang=<?=$idbarang?>"><?=$namabarang?></a></strong></td>
                                        <td><?=$deskripsi?></td>
                                        <td><?=$stock?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?=$idbarang;?>">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusbarang<?=$idbarang;?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Barang -->
                                    <div class="modal fade" id="editModal<?=$idbarang;?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post" action="function.php" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="idbarang" value="<?=$idbarang;?>">
                                                        <input type="hidden" name="gambarlama" value="<?=$gambar;?>">

                                                        <input class="form-control mb-3" type="text" name="namabarang" value="<?=$namabarang;?>" required>
                                                        <input class="form-control mb-3" type="text" name="deskripsi" value="<?=$deskripsi;?>" required>
                                                        <input class="form-control mb-3" type="number" name="stock" value="<?=$stock;?>" required>
                                                        <center>
                                                            <img src="uploads/<?=$gambar;?>" width="100">
                                                        </center>

                                                        <label>Upload Gambar Baru</label>
                                                        <input type="file" name="gambar" class="form-control mb-3" accept="image/*">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="editbarang">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    

                                    <!-- Modal Hapus Barang -->
                                    <div class="modal fade" id="hapusbarang<?=$idbarang;?>" tabindex="-1" aria-labelledby="hapusbarangLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="hapusbarangLabel">Hapus Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post" action="function.php">
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus barang: <?=$namabarang;?>?
                                                        <input type="hidden" name="idbarang" value="<?=$idbarang;?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger" name="hapusBarang">Hapus</button>
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

                <!-- Modal for Adding Stock -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post" action="function.php" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input class="form-control mb-3" type="text" name="namabarang" placeholder="Nama Barang" required>
                                    <input class="form-control mb-3" type="text" name="deskripsi" placeholder="Deskripsi Barang" required>
                                    <input class="form-control mb-3" type="number" name="stock" placeholder="Stock" required>
                                    <!-- Tambahkan Field Upload Gambar -->
                                    <label>Upload Gambar</label>
                                    <input class="form-control mb-3" type="file" name="gambar" accept="image/*" required>   
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="addnewbarang">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </main>

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
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    
</body>
</html>
