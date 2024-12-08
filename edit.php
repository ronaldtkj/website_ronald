<?php
require 'function.php';
require 'cek.php';

if(isset($_POST['editbarang'])){
    $idbarang = $_POST['idbarang'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // Query untuk update data barang berdasarkan idbarang
    $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi', stok='$stok' WHERE idbarang='$idbarang'");

    if($update){
        // Redirect ke halaman index setelah berhasil mengedit
        header("Location: index.php");
    } else {
        echo "Gagal mengedit data";
        header("Location: index.php");
    }
}
?>