<?php
session_start();
include "pages/db.php";

$email = $_POST['email'];
$pass  = $_POST['password'];

$q = $conn->query("SELECT * FROM users WHERE email='$email'");
if ($q->num_rows > 0) {
    $user = $q->fetch_assoc();
    if (password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']   = $user['nama'];
        $_SESSION['role']    = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: pages/admin.php");
        } else {
            header("Location: pages/usr.php");
        }
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
        echo "<script>window.location.href='index.html';</script>";
        exit;
    }
} else {
    echo "<script>alert('Username atau password salah!');</script>";
    echo "<script>window.location.href='index.html';</script>";
    exit;
}
?>
