<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}
include "db.php";

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$q = $conn->query("SELECT * FROM gadai WHERE id=$id AND user_id=$user_id");
if ($q->num_rows == 0) {
    echo "Data tidak ditemukan.";
    exit;
}
$d = $q->fetch_assoc();
?>
<h1>Detail Barang Gadai</h1>
<p><b>Nama Barang:</b> <?php echo $d['nama_barang']; ?></p>
<p><b>Deskripsi:</b> <?php echo $d['deskripsi']; ?></p>
<p><b>Kategori:</b> <?php echo $d['kategori']; ?></p>
<p><b>Harga:</b> Rp <?php echo number_format($d['harga']); ?></p>
<p><b>Lokasi:</b> <?php echo $d['lokasi']; ?></p>
<p><b>Status:</b> <?php echo $d['status']; ?></p>

<h3>Foto Barang</h3>
<?php for ($i=1; $i<=5; $i++): ?>
    <?php if (!empty($d["foto$i"])): ?>
        <img src="uploads/<?php echo $d["foto$i"]; ?>" width="200" style="margin:5px;">
    <?php endif; ?>
<?php endfor; ?>

<p><a href="history.php">⬅ Kembali ke History</a></p>
<p><a href="chat.php?id=<?php echo $d['id']; ?>">💬 Chat dengan Admin</a></p>
