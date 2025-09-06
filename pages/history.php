<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}
include "db.php";

$user_id = $_SESSION['user_id'];
$q = $conn->query("SELECT * FROM gadai WHERE user_id=$user_id ORDER BY created_at DESC");
?>
<h1>History Gadai Saya</h1>
<p><a href="dashboard.php">⬅ Kembali ke Dashboard</a></p>
<table border="1" cellpadding="5">
<tr>
    <th>Nama Barang</th>
    <th>Kategori</th>
    <th>Harga</th>
    <th>Status</th>
    <th>Tanggal</th>
    <th>Detail</th>
</tr>
<?php while($d = $q->fetch_assoc()){ ?>
<tr>
    <td><?php echo $d['nama_barang']; ?></td>
    <td><?php echo $d['kategori']; ?></td>
    <td>Rp <?php echo number_format($d['harga']); ?></td>
    <td><?php echo $d['status']; ?></td>
    <td><?php echo $d['created_at']; ?></td>
    <td><a href="detail_user.php?id=<?php echo $d['id']; ?>">🔍 Lihat</a></td>
</tr>
<?php } ?>
</table>
