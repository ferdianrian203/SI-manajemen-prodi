<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

$judul = "Edit Mahasiswa";

$id = $_GET['id'] ?? 0;


// =====================================
// DATA MAHASISWA
// =====================================

$query = mysqli_prepare(
    $koneksi,
    "SELECT * FROM mahasiswa WHERE id = ?"
);

mysqli_stmt_bind_param(
    $query,
    "i",
    $id
);

mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);


if (mysqli_num_rows($result) == 0) {

    header("Location: index.php?pesan=gagal");

    exit;

}

$data = mysqli_fetch_assoc($result);


// =====================================
// DATA PRODI
// =====================================

$query_prodi = mysqli_query(
    $koneksi,
    "SELECT *
     FROM prodi
     ORDER BY nama_prodi ASC"
);

?>

<?php include "../template/header.php"; ?>

<?php include "../template/sidebar.php"; ?>

<div class="main-content">

    <?php include "../template/navbar.php"; ?>

    <div class="content">

        <div class="page-header">

            <div>

                <h1>Edit Mahasiswa</h1>

                <p>
                    Perbarui data mahasiswa
                </p>

            </div>

        </div>


        <div class="form-container">

            <form
                action="proses_edit.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $data['id']; ?>"
                >


                <div class="form-group">

                    <label>NIM</label>

                    <input
                        type="text"
                        name="nim"
                        value="<?php echo htmlspecialchars($data['nim']); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Nama Lengkap</label>

                    <input
                        type="text"
                        name="nama"
                        value="<?php echo htmlspecialchars($data['nama']); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Jenis Kelamin</label>

                    <select
                        name="jenis_kelamin"
                        required
                    >

                        <option value="Laki-laki"
                            <?php
                            if ($data['jenis_kelamin'] == 'Laki-laki') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            <?php
                            if ($data['jenis_kelamin'] == 'Perempuan') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Perempuan
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>Tempat Lahir</label>

                    <input
                        type="text"
                        name="tempat_lahir"
                        value="<?php echo htmlspecialchars($data['tempat_lahir']); ?>"
                    >

                </div>


                <div class="form-group">

                    <label>Tanggal Lahir</label>

                    <input
                        type="date"
                        name="tanggal_lahir"
                        value="<?php echo $data['tanggal_lahir']; ?>"
                    >

                </div>


                <div class="form-group">

                    <label>Program Studi</label>

                    <select
                        name="id_prodi"
                        required
                    >

                        <?php while ($prodi = mysqli_fetch_assoc($query_prodi)) { ?>

                            <option
                                value="<?php echo $prodi['id']; ?>"

                                <?php

                                if (
                                    $data['id_prodi']
                                    ==
                                    $prodi['id']
                                ) {

                                    echo 'selected';

                                }

                                ?>

                            >

                                <?php
                                echo htmlspecialchars(
                                    $prodi['kode_prodi']
                                );
                                ?>

                                -

                                <?php
                                echo htmlspecialchars(
                                    $prodi['nama_prodi']
                                );
                                ?>

                                (<?php echo $prodi['jenjang']; ?>)

                            </option>

                        <?php } ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>Angkatan</label>

                    <input
                        type="number"
                        name="angkatan"
                        min="2000"
                        max="2100"
                        value="<?php echo $data['angkatan']; ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Nomor HP</label>

                    <input
                        type="text"
                        name="no_hp"
                        value="<?php echo htmlspecialchars($data['no_hp']); ?>"
                    >

                </div>


                <div class="form-group">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        value="<?php echo htmlspecialchars($data['email']); ?>"
                    >

                </div>


                <div class="form-group">

                    <label>Alamat</label>

                    <textarea name="alamat"><?php echo htmlspecialchars($data['alamat']); ?></textarea>

                </div>


                <div class="form-group">

                    <label>Status</label>

                    <select
                        name="status"
                        required
                    >

                        <option value="Aktif"
                            <?php
                            if ($data['status'] == 'Aktif') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Aktif
                        </option>

                        <option value="Cuti"
                            <?php
                            if ($data['status'] == 'Cuti') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Cuti
                        </option>

                        <option value="Lulus"
                            <?php
                            if ($data['status'] == 'Lulus') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Lulus
                        </option>

                        <option value="Nonaktif"
                            <?php
                            if ($data['status'] == 'Nonaktif') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Nonaktif
                        </option>

                    </select>

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update
                    </button>

                    <a
                        href="index.php"
                        class="btn btn-secondary"
                    >
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include "../template/footer.php"; ?>