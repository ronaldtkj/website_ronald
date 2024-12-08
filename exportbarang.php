<?php
$host = 'localhost';
$dbname = 'stockbarang';
$username = 'root';
$password = '';

// Koneksi ke database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Query untuk mengambil data
$sql = "SELECT * FROM barang"; // Ganti dengan nama tabel yang ingin diekspor
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Mengatur header untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="data_export.csv"');

// Membuat file pointer ke output
$output = fopen('php://output', 'w');

// Menulis header kolom
fputcsv($output, array('Kolom1', 'Kolom2', 'Kolom3')); // Ganti dengan nama kolom yang sesuai

// Menulis data ke file CSV
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

// Menutup file pointer
fclose($output);
exit();
?>