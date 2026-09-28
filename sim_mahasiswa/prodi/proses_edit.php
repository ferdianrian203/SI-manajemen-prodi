<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";


// Mengambil data dari form
$id = $_POST['id'];

$kode_prodi = strtoupper(trim($_POST['kode_prodi']));
$nama_prodi = trim($_POST['nama_prodi']);
$jenjang = $_POST['jenjang'];
$keterangan = trim($_POST['keterangan']);


// Mengecek apakah kode prodi sudah digunakan
// oleh data lain
$cek = mysqli_prepare(
    $koneksi,

    "SELECT id
     FROM prodi
     WHERE kode_prodi = ?
     AND id != ?"
);

mysqli_stmt_bind_param(
    $cek,
    "si",
    $kode_prodi,
    $id
);

mysqli_stmt_execute($cek);

$hasil_cek = mysqli_stmt_get_result($cek);


if (mysqli_num_rows($hasil_cek) > 0) {

    echo "
        <script>
            alert('Kode program studi sudah digunakan oleh data lain!');
            history.back();
        </script>
    ";

    exit;
}


// Update data
$query = mysqli_prepare(
    $koneksi,

    "UPDATE prodi

     SET
        kode_prodi = ?,
        nama_prodi = ?,
        jenjang = ?,
        keterangan = ?

     WHERE id = ?"
);


mysqli_stmt_bind_param(
    $query,
    "ssssi",
    $kode_prodi,
    $nama_prodi,
    $jenjang,
    $keterangan,
    $id
);


// Menjalankan update
if (mysqli_stmt_execute($query)) {

    header("Location: index.php?pesan=edit");
    exit;

} else {

    header("Location: index.php?pesan=gagal");
    exit;

}

?>