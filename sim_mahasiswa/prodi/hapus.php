<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";


// Mengambil ID
$id = $_GET['id'] ?? 0;


// Menghapus data
$query = mysqli_prepare(
    $koneksi,
    "DELETE FROM prodi WHERE id = ?"
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

    /*
     * Bisa gagal apabila prodi masih
     * digunakan oleh data mahasiswa.
     */

    echo "
        <script>
            alert(
                'Program studi tidak dapat dihapus karena masih digunakan oleh mahasiswa!'
            );

            window.location='index.php';
        </script>
    ";

    exit;
}

?>