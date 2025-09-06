<?php
session_start();
include "db.php";

$user_id     = $_SESSION['user_id'];
$nama_barang = $_POST['nama_barang'];
$deskripsi   = $_POST['deskripsi'];
$kategori    = $_POST['kategori'];
$harga       = $_POST['harga'];
$lokasi      = $_POST['lokasi'];

$uploads = [];
for ($i=1; $i<=5; $i++) {
    $filename = time()."_".$_FILES["foto$i"]["name"];
    move_uploaded_file($_FILES["foto$i"]["tmp_name"], "uploads/".$filename);
    $uploads[$i] = $filename;
}

$sql = "INSERT INTO gadai (user_id, nama_barang, deskripsi, kategori, harga, lokasi, 
        foto1, foto2, foto3, foto4, foto5) 
        VALUES ('$user_id','$nama_barang','$deskripsi','$kategori','$harga','$lokasi',
        '{$uploads[1]}','{$uploads[2]}','{$uploads[3]}','{$uploads[4]}','{$uploads[5]}')";

if ($conn->query($sql)) {
    echo "Barang berhasil diajukan untuk digadai!";
} else {
    echo "Error: ".$conn->error;
}
?>
