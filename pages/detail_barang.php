<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}
include "db.php";

$id = $_GET['id'];
$q  = $conn->query("SELECT g.*, u.email, u.nama 
                    FROM gadai g 
                    JOIN users u ON g.user_id=u.id 
                    WHERE g.id=$id");
$d = $q->fetch_assoc();
?>
<h1>Detail Barang Gadai</h1>
<p><b>Nama Barang:</b> <?php echo $d['nama_barang']; ?></p>
<p><b>Deskripsi:</b> <?php echo $d['deskripsi']; ?></p>
<p><b>Kategori:</b> <?php echo $d['kategori']; ?></p>
<p><b>Harga:</b> Rp <?php echo number_format($d['harga']); ?></p>
<p><b>Lokasi:</b> <?php echo $d['lokasi']; ?></p>
<p><b>User:</b> <?php echo $d['nama']." (".$d['email'].")"; ?></p>
<p><b>Status:</b> <?php echo $d['status']; ?></p>

<h3>Foto Barang</h3>
<?php for ($i=1; $i<=5; $i++): ?>
    <?php if (!empty($d["foto$i"])): ?>
        <img src="uploads/<?php echo $d["foto$i"]; ?>" width="200" style="margin:5px;">
    <?php endif; ?>
<?php endfor; ?>

<p>
    <?php if ($d['status'] == 'pending'): ?>
        <a href="update_status.php?id=<?php echo $d['id']; ?>&status=confirmed">✅ Konfirmasi</a> | 
        <a href="update_status.php?id=<?php echo $d['id']; ?>&status=cancel" onclick="return confirm('Yakin batalkan transaksi ini?')">❌ Cancel</a>
    <?php elseif ($d['status'] == 'confirmed'): ?>
        <a href="update_status.php?id=<?php echo $d['id']; ?>&status=selesai">✔ Tandai Selesai</a>
    <?php elseif ($d['status'] == 'cancel'): ?>
        ❌ Transaksi dibatalkan
    <?php else: ?>
        ✅ Barang sudah selesai
    <?php endif; ?>
</p>


<p><a href="admin.php">⬅ Kembali ke Admin Panel</a></p>
<p><a href="chat.php?id=<?php echo $d['id']; ?>">💬 Buka Chat</a></p>

