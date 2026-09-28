<?php

session_start();

include "../config/koneksi.php";

// Mengambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Mencari username di database
$query = "SELECT * FROM users WHERE username = '$username'";

$result = mysqli_query($koneksi, $query);

// Mengecek apakah username ditemukan
if (mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

    // Mengecek password
    if (password_verify($password, $user['password'])) {

        // Membuat session
        $_SESSION['login'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['level'] = $user['level'];

        // Masuk ke dashboard
        header("Location: ../dashboard/index.php");
        exit;

    } else {

        // Password salah
        header("Location: login.php?error=1");
        exit;
    }

} else {

    // Username tidak ditemukan
    header("Location: login.php?error=1");
    exit;
}

?>