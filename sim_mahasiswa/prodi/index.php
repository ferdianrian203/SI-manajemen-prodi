<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

$judul = "Program Studi";

// Mengambil semua data program studi
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM prodi ORDER BY nama_prodi ASC"
);

?>

<?php include "../template/header.php"; ?>

<?php include "../template/sidebar.php"; ?>

<div class="main-content">

    <?php include "../template/navbar.php"; ?>

    <div class="content">

        <div class="page-header">

            <div>
                <h1>Program Studi</h1>

                <p>
                    Data program studi yang tersedia
                </p>
            </div>

            <a href="tambah.php" class="btn btn-primary">
                + Tambah Program Studi
            </a>

        </div>


        <?php if (isset($_GET['pesan'])) { ?>

            <?php if ($_GET['pesan'] == 'tambah') { ?>

                <div class="alert alert-success">
                    Program studi berhasil ditambahkan.
                </div>

            <?php } ?>

            <?php if ($_GET['pesan'] == 'edit') { ?>

                <div class="alert alert-success">
                    Program studi berhasil diperbarui.
                </div>

            <?php } ?>

            <?php if ($_GET['pesan'] == 'hapus') { ?>

                <div class="alert alert-success">
                    Program studi berhasil dihapus.
                </div>

            <?php } ?>

            <?php if ($_GET['pesan'] == 'gagal') { ?>

                <div class="alert alert-danger">
                    Data program studi gagal diproses.
                </div>

            <?php } ?>

        <?php } ?>


        <div class="table-container">

            <div class="table-header">

                <h3>Daftar Program Studi</h3>

            </div>

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Kode Prodi</th>

                        <th>Nama Program Studi</th>

                        <th>Jenjang</th>

                        <th>Keterangan</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                <?php

                $no = 1;

                while ($data = mysqli_fetch_assoc($query)) {

                ?>

                    <tr>

                        <td>
                            <?php echo $no++; ?>
                        </td>

                        <td>
                            <strong>
                                <?php echo htmlspecialchars($data['kode_prodi']); ?>
                            </strong>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($data['nama_prodi']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($data['jenjang']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($data['keterangan']); ?>
                        </td>

                        <td>

                            <a
                                href="edit.php?id=<?php echo $data['id']; ?>"
                                class="btn btn-warning"
                            >
                                Edit
                            </a>

                            <a
                                href="hapus.php?id=<?php echo $data['id']; ?>"
                                class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus program studi ini?')"
                            >
                                Hapus
                            </a>

                        </td>

                    </tr>

                <?php } ?>

                <?php if (mysqli_num_rows($query) == 0) { ?>

                    <tr>

                        <td colspan="6" style="text-align:center;">
                            Belum ada data program studi.
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include "../template/footer.php"; ?>