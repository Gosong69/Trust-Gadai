<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}
?>
<h1>Dashboard</h1>
<p>Selamat datang, <?php echo $_SESSION['email']; ?></p>
<ul>
    <li><a href="gadai.php">Gadai Barang</a></li>
    <li><a href="history.php">History Gadai</a></li>
    <li><a href="#">Ambil Barang Gadai</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
