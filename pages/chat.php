<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$gadai_id = $_GET['id'];

// cek apakah user punya hak lihat chat ini
if ($_SESSION['role'] == 'user') {
    $user_id = $_SESSION['user_id'];
    $cek = $conn->query("SELECT * FROM gadai WHERE id=$gadai_id AND user_id=$user_id");
    if ($cek->num_rows == 0) {
        echo "Anda tidak berhak mengakses chat ini.";
        exit;
    }
}

// ambil pesan chat
$q = $conn->query("SELECT * FROM chat WHERE gadai_id=$gadai_id ORDER BY created_at ASC");

// jika ada pesan baru dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $msg = $conn->real_escape_string($_POST['message']);
    
    // Cegah trigger ModSecurity
    $msg = str_ireplace(
        ['insert','select','delete','update','drop','union'],
        '[blocked]',
        $msg
    );

    $role = $conn->real_escape_string($_SESSION['role']);
    $conn->query("INSERT INTO chat (gadai_id, sender_role, message) VALUES ($gadai_id, '$role', '$msg')");
    header("Location: chat.php?id=$gadai_id");
    exit;
}
?>
<h2>Chat Transaksi Gadai #<?php echo $gadai_id; ?></h2>
<div style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:scroll;">
    <?php while($c = $q->fetch_assoc()){ ?>
        <p><b><?php echo ucfirst($c['sender_role']); ?>:</b> <?php echo $c['message']; ?> 
        <i>(<?php echo $c['created_at']; ?>)</i></p>
    <?php } ?>
</div>
<form method="post" action="">
    <textarea name="message" rows="3" cols="50" placeholder="Tulis pesan..." required></textarea><br>
    <button type="submit">Kirim</button>
</form>
<p><a href="<?php echo ($_SESSION['role']=='admin') ? 'admin.php':'history.php'; ?>">⬅ Kembali</a></p>
