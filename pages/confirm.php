<?php
include "db.php";

$id = $_GET['id'];

$conn->query("UPDATE gadai SET status='confirmed' WHERE id=$id");

$q = $conn->query("SELECT g.*, u.email FROM gadai g JOIN users u ON g.user_id=u.id WHERE g.id=$id");
$d = $q->fetch_assoc();

$to      = $d['email'];
$subject = "Konfirmasi Gadai Barang";
$message = "Barang anda '".$d['nama_barang']."' telah dikonfirmasi. Petugas akan datang ke rumah anda.";
$headers = "From: admin@gadai-cepat.com";

mail($to, $subject, $message, $headers);

echo "Barang berhasil dikonfirmasi dan email terkirim.";
?>
