<?php
require("koneksi.php"); // memanggil file koneksi.php untuk koneksi ke database

// Query untuk mengambil data
$query = "SELECT waktu, suhu_udara FROM suhus ORDER BY waktu ASC";
$result = mysqli_query($koneksi, $query);

// Menyimpan hasil query dalam array
$data = array();
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Mengembalikan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
