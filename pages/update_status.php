<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}
include "db.php";

$id     = $_GET['id'];
$status = $_GET['status'];

// Update status
$conn->query("UPDATE gadai SET status='$status' WHERE id=$id");

// Ambil data user buat kirim email
$q = $conn->query("SELECT g.*, u.email FROM gadai g JOIN users u ON g.user_id=u.id WHERE g.id=$id");
$d = $q->fetch_assoc();

$to      = $d['email'];
$subject = "Update Status Gadai Barang";
$message = "Status barang '".$d['nama_barang']."' telah berubah menjadi: ".$status;
$headers = "From: admin@gadai-cepat.com";

mail($to, $subject, $message, $headers);

header("Location: admin.php");
exit;
