<?php
session_start();
$alert = "";
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'stockbarang'; 

$conn = mysqli_connect($host, $user, $pass, $db);

// menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_POST['gambar'];
    $stock = $_POST['stock'];

    // upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $folder = 'docs/' . $gambar;

    //pidahkan ke folder uploads
    move_uploaded_file($tmp_name, $folder);
    
    $addtotable = mysqli_query($conn, "INSERT INTO barang (namabarang, gambar, deskripsi, stock) VALUES('$namabarang','$gambar','$deskripsi', '$stock')");
    
    if($addtotable){
        $alert = "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil',
                text: 'Data $namabarang Telah Ditambah',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
        });
        </script>";
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}



// menambah barang masuk
// if(isset($_POST['barangmasuk'])){
//     $namabarang = $_POST['namabarang'];
//     $keterangan = $_POST['keterangan'];
    
//     $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (namabarang, keterangan) VALUES('$namabarang', '$keterangan')");
    
//     if($addtomasuk){
//         header('location:masuk.php');
//     } else {
//         echo 'Gagal';
//         header('location:masuk.php');
//     }
// }

 // menambah barang masuk
 if(isset($_POST['barangmasuk'])){
    $idbarang = $_POST['idbarang'];
    $gambar_barang = $_POST['gambar_barang'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM barang WHERE idbarang='$idbarang'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty)  VALUES('$idbarang', '$keterangan', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE barang SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$idbarang'");

    if($addtomasuk && $updatestockmasuk){
            echo "
            <script>
            alert('Barang Berhasil Ditambah');
            window.location.href = 'masuk.php'
            </script>
            ";
            } else {
                echo "
                <script>
                alert('Barang Gagal Ditambah');
                window.location.href = 'masuk.php'
                </script>
                ";
            }
    // if($addtomasuk&&$updatestockmasuk){
    //     echo '<script type="text/javascript">alert("Berhasil);</script>';
    // } else {
    //     echo '<script type="text/javascript">alert("Gagal);</script>';
    // }
}


// menambah barang keluar
    if(isset($_POST['barangkeluar'])){
        $idbarang = $_POST['idbarang'];
        $gambar_barang = $_POST['gambar_barang'];
        $penerima = $_POST['penerima'];
        $qty = $_POST['qty'];

        $cekstocksekarang = mysqli_query($conn, "SELECT * FROM barang WHERE idbarang='$idbarang'");
        $ambildatanya = mysqli_fetch_array($cekstocksekarang);

        $stocksekarang = $ambildatanya['stock'];
        $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

        $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty)  VALUES('$idbarang', '$penerima', '$qty')");
        $updatestock = mysqli_query($conn, "UPDATE barang SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$idbarang'");



        if($addtokeluar&&$updatestock){
            $alert = "
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Data $namabarang Telah Ditambah',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'keluar.php';
                    }
                });
            });
            </script>";
        } else {
            echo '<script type="text/javascript">alert("Gagal);</script>';
        }
    };

    // Edit barang
if (isset($_POST['editbarang'])) {
    $idbarang = $_POST['idbarang'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $gambarlama = $_POST['gambarlama'];

    $gambarbaru = $_FILES['gambar']['name'];
    $imagestmpname = $_FILES['gambar']['tmp_name'];

    // Cek jika ada gambar baru yang diunggah
    if (!empty($gambarbaru)) {
        $imagefiletype = pathinfo($gambarbaru, PATHINFO_EXTENSION);
        $encryptedname = md5(uniqid($gambarbaru, true)) . '.' . $imagefiletype;

        // Hapus gambar lama
        if (file_exists('docs/' . $gambarlama)) {
            unlink('docs/' . $gambarlama);
        }

        // Upload gambar baru
        move_uploaded_file($imagestmpname, 'docs/' . $encryptedname);
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $encryptedname = $gambarlama;
    }
    
    // Query untuk update data barang berdasarkan idbarang
    $update = "UPDATE barang SET namabarang = ?, gambar = ?, deskripsi = ?, stock = ? WHERE idbarang = ?";
    $stmtupdate = $conn->prepare($update);
    $stmtupdate->bind_param("sssii", $namabarang, $encryptedname, $deskripsi, $stock, $idbarang);

    if ($stmtupdate->execute()) {
            // Redirect ke halaman index setelah berhasil mengedit
            $alert = "
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Update Berhasil',
                    text: 'Data $namabarang Telah Diupdate',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
            });
            </script>";
        } else {
            // echo "Gagal mengedit data";
            header("Location: index.php");
        }
    }


    // HAPUS
    if(isset($_POST['hapusBarang'])){
        $idbarang = $_POST['idbarang'];
    
        $hapus = mysqli_query($conn, "DELETE FROM barang WHERE idbarang='$idbarang'");
    
        if($hapus){
            $alert = "
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Data Barang Telah Di Hapus',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
            });
            </script>";
        } else {
            echo "Gagal menghapus data";
            header("Location: index.php");
        }
    }
    
    // Hapus barang masuk
    if (isset($_POST['hapusBarangmasuk'])) {
        $idbarang = $_POST['idbarang'];  
        $qty = $_POST['qty'];  
        $idmasuk = $_POST['idmasuk'];  
    
            $getdatastock = mysqli_query($conn, "SELECT stock FROM barang WHERE idbarang = '$idbarang'");
            $data = mysqli_fetch_array($getdatastock);
            $stock = $data['stock'];
    
            $selisih = $stock - $qty;
    
            $update = mysqli_query($conn, "UPDATE barang SET stock = '$selisih' WHERE idbarang = '$idbarang'");
            $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk = '$idmasuk'");
    
            if ($update && $hapusdata) {
                $alert = "
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Data Barang Telah Di Hapus',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'Masuk.php';
                        }
                    });
                });
                </script>";
            } else {
                echo "Gagal menghapus barang masuk!";
                header("Location: masuk.php");
            }
        } else {
            echo "Input tidak valid!";
        }
    
    
    // Hapus barang masuk
    if (isset($_POST['hapusBarangkeluar'])) {
        $idbarang = $_POST['idbarang'];  
        $qty = $_POST['qty'];  
        $idkeluar = $_POST['idkeluar'];  
    
            $getdatastock = mysqli_query($conn, "SELECT stock FROM barang WHERE idbarang = '$idbarang'");
            $data = mysqli_fetch_array($getdatastock);
            $stock = $data['stock'];
    
            $selisih = $stock+$qty;
    
            $update = mysqli_query($conn, "UPDATE barang SET stock = '$selisih' WHERE idbarang = '$idbarang'");
            $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar = '$idkeluar'");
    
            if ($update && $hapusdata) {
                $alert = "
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Data Barang Telah Di Hapus',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'keluar.php';
                        }
                    });
                });
                </script>";
            } else {
                echo "Gagal menghapus barang masuk!";
                header("Location: masuk.php");
            }
        } else {
            echo "Input tidak valid!";
        }

echo $alert;

// ubah barang
if (isset($_POST['updatebarang'])) {
    $idbarang = $_POST['idbarang'];
    $namabarang = $_POST['namabarang'];
    $stock = $_POST['stock'];
    $deskripsi = $_POST['deskripsi'];
    $gambarbaru = $_FILES['gambar']['name'];
    $gambarlama = $_POST['gambarlama'];
    if (!empty($gambarbaru)) {
        // Proses upload gambar baru
        $imagestmpname = $_FILES['gambar']['tmp_name'];
        $imageFileType = pathinfo($gambarbaru, PATHINFO_EKSTENSION);
        $encryptedName = md5(uniqid($gambarbaru, true)) . '.' . $imageFileType;
        // Hapus gambar lama
        if (file_exists('../docs/' . $gambarlama)) {
            unlink('../docs/' . $gambarlama);
        }
        // Memindahkan File ke Direktori Tujuan
        move_uploaded_file($imagestmpname, '../docs/' . $encryptedName);
        // Update database dengan gambar baru
        $queryUpdate = "UPDATE barang  SET namabarang = ?, stok = ?, deskripsi = ?, gambar = ? WHERE idbarang = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("sissi", $namabarang, $stok, $deskripsi, $encryptedName, $idbarang);
    } else {
        // Update database tanpa mengubah gambar
        $queryUpdate = "UPDATE barang  SET namabarang = ?, stok = ?, deskripsi = ?, gambar = ? WHERE idbarang = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("sisi", $namabarang, $stok, $deskripsi, $encryptedName, $idbarang);
    }
    if  ($stmtUpdate->execute()) {
        header("Location: ../index.php?process=successup");
        exit();
    } else {
        die('Error executing statement: ' . $stmtUpdate->error);
    }
    $stmtUpdate->close();
}

?>
<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>