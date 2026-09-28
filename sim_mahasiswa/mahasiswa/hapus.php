<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";


$id = $_GET['id'] ?? 0;


$query = mysqli_prepare(
    $koneksi,
    "DELETE FROM mahasiswa WHERE id = ?"
);


mysqli_stmt_bind_param(
    $query,
    "i",
    $id
);


if (mysqli_stmt_execute($query)) {

    header("Location: index.php?pesan=hapus");

    exit;

} else {

    header("Location: index.php?pesan=gagal");

    exit;

}

?>