<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}
include "db.php";

$q = $conn->query("SELECT g.*, u.email FROM gadai g JOIN users u ON g.user_id=u.id");
?>
<h1>Admin Panel</h1>
<p>Halo, <?php echo $_SESSION['email']; ?> | <a href="logout.php">Logout</a></p>
<table border="1" cellpadding="5">
<tr>
    <th>Nama Barang</th>
    <th>User</th>
    <th>Kategori</th>
    <th>Harga</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
<?php while($d = $q->fetch_assoc()){ ?>
<tr>
    <td><?php echo $d['nama_barang']; ?></td>
    <td><?php echo $d['email']; ?></td>
    <td><?php echo $d['kategori']; ?></td>
    <td><?php echo number_format($d['harga']); ?></td>
    <td><?php echo $d['status']; ?></td>
    <td>
    <a href="detail_barang.php?id=<?php echo $d['id']; ?>">🔍 Detail</a> | 
    <?php if ($d['status'] == 'pending'): ?>
        <a href="update_status.php?id=<?php echo $d['id']; ?>&status=confirmed">✅ Konfirmasi</a> | 
        <a href="update_status.php?id=<?php echo $d['id']; ?>&status=cancel" onclick="return confirm('Yakin batalkan transaksi ini?')">❌ Cancel</a>
    <?php elseif ($d['status'] == 'confirmed'): ?>
        <a href="update_status.php?id=<?php echo $d['id']; ?>&status=selesai">✔ Tandai Selesai</a>
    <?php elseif ($d['status'] == 'cancel'): ?>
        ❌ Dibatalkan
    <?php else: ?>
        ✅ Sudah selesai
    <?php endif; ?>
</td>
</tr>
<?php } ?>
</table>
