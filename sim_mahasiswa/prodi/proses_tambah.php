<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";


// Mengambil data dari form
$kode_prodi = strtoupper(trim($_POST['kode_prodi']));
$nama_prodi = trim($_POST['nama_prodi']);
$jenjang = $_POST['jenjang'];
$keterangan = trim($_POST['keterangan']);


// Mengecek apakah kode prodi sudah digunakan
$cek = mysqli_prepare(
    $koneksi,
    "SELECT id FROM prodi WHERE kode_prodi = ?"
);

mysqli_stmt_bind_param(
    $cek,
    "s",
    $kode_prodi
);

mysqli_stmt_execute($cek);

$hasil_cek = mysqli_stmt_get_result($cek);


if (mysqli_num_rows($hasil_cek) > 0) {

    echo "
        <script>
            alert('Kode program studi sudah digunakan!');
            window.location='tambah.php';
        </script>
    ";

    exit;
}


// Menyimpan data
$query = mysqli_prepare(
    $koneksi,

    "INSERT INTO prodi
    (kode_prodi, nama_prodi, jenjang, keterangan)
    VALUES (?, ?, ?, ?)"
);


mysqli_stmt_bind_param(
    $query,
    "ssss",
    $kode_prodi,
    $nama_prodi,
    $jenjang,
    $keterangan
);


// Menjalankan query
if (mysqli_stmt_execute($query)) {

    header("Location: index.php?pesan=tambah");
    exit;

} else {

    header("Location: index.php?pesan=gagal");
    exit;

}

?>