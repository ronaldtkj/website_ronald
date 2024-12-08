<?php
require 'function.php';
require 'cek.php';

if(isset($_POST['hapusBarang'])){
    $idbarang = $_POST['idbarang'];

    $hapus = mysqli_query($conn, "DELETE FROM barang WHERE idbarang='$idbarang'");

    if($hapus){
        header("Location: index.php");
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
            header("Location: masuk.php");
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
    $idmasuk = $_POST['idkeluar'];  

        $getdatastock = mysqli_query($conn, "SELECT stock FROM barang WHERE idbarang = '$idbarang'");
        $data = mysqli_fetch_array($getdatastock);
        $stock = $data['stock'];

        $selisih = $stock+$qty;

        $update = mysqli_query($conn, "UPDATE barang SET stock = '$selisih' WHERE idbarang = '$idbarang'");
        $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar = '$idkeluar'");

        if ($update && $hapusdata) {
            header("Location: masuk.php");
        } else {
            echo "Gagal menghapus barang masuk!";
            header("Location: masuk.php");
        }
    } else {
        echo "Input tidak valid!";
    }
?>
