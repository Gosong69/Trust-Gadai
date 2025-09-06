<?php
include "pages/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $token    = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // cek apakah email sudah terdaftar
    $cek = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($cek->num_rows > 0) {
        echo "Email sudah digunakan!";
    } else {
        $sql = "INSERT INTO users (nama,email,token,password) VALUES ('$nama','$email','$token','$password')";
        if ($conn->query($sql)) {
            echo "<script>alert('Registrasi berhasil! Silakan login.');</script>";
            echo "<script>window.location.href='index.html';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
?>
<?php } ?>
