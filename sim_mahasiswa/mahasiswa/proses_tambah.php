<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";


// Mengambil data form
$nim = trim($_POST['nim']);
$nama = trim($_POST['nama']);
$jenis_kelamin = $_POST['jenis_kelamin'];
$tempat_lahir = trim($_POST['tempat_lahir']);
$tanggal_lahir = $_POST['tanggal_lahir'];
$id_prodi = $_POST['id_prodi'];
$angkatan = $_POST['angkatan'];
$no_hp = trim($_POST['no_hp']);
$email = trim($_POST['email']);
$alamat = trim($_POST['alamat']);
$status = $_POST['status'];


// =====================================
// CEK NIM
// =====================================

$cek = mysqli_prepare(
    $koneksi,
    "SELECT id FROM mahasiswa WHERE nim = ?"
);

mysqli_stmt_bind_param(
    $cek,
    "s",
    $nim
);

mysqli_stmt_execute($cek);

$hasil_cek = mysqli_stmt_get_result($cek);


if (mysqli_num_rows($hasil_cek) > 0) {

    echo "
        <script>

            alert('NIM sudah digunakan!');

            history.back();

        </script>
    ";

    exit;
}


// =====================================
// SIMPAN DATA
// =====================================

$query = mysqli_prepare(
    $koneksi,

    "INSERT INTO mahasiswa
    (
        nim,
        nama,
        jenis_kelamin,
        tempat_lahir,
        tanggal_lahir,
        alamat,
        no_hp,
        email,
        id_prodi,
        angkatan,
        status
    )

    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);


mysqli_stmt_bind_param(
    $query,
    "ssssssssiis",
    $nim,
    $nama,
    $jenis_kelamin,
    $tempat_lahir,
    $tanggal_lahir,
    $alamat,
    $no_hp,
    $email,
    $id_prodi,
    $angkatan,
    $status
);


if (mysqli_stmt_execute($query)) {

    header("Location: index.php?pesan=tambah");

    exit;

} else {

    header("Location: index.php?pesan=gagal");

    exit;

}

?>