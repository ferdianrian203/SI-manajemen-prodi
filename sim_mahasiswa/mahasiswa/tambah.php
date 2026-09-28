<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

$judul = "Tambah Mahasiswa";


// Mengambil data program studi
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

                <h1>Tambah Mahasiswa</h1>

                <p>
                    Tambahkan data mahasiswa baru
                </p>

            </div>

        </div>


        <div class="form-container">

            <form
                action="proses_tambah.php"
                method="POST"
            >


                <div class="form-group">

                    <label>NIM</label>

                    <input
                        type="text"
                        name="nim"
                        placeholder="Masukkan NIM"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Nama Lengkap</label>

                    <input
                        type="text"
                        name="nama"
                        placeholder="Masukkan nama lengkap"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Jenis Kelamin</label>

                    <select
                        name="jenis_kelamin"
                        required
                    >

                        <option value="">
                            -- Pilih Jenis Kelamin --
                        </option>

                        <option value="Laki-laki">
                            Laki-laki
                        </option>

                        <option value="Perempuan">
                            Perempuan
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>Tempat Lahir</label>

                    <input
                        type="text"
                        name="tempat_lahir"
                        placeholder="Contoh: Medan"
                    >

                </div>


                <div class="form-group">

                    <label>Tanggal Lahir</label>

                    <input
                        type="date"
                        name="tanggal_lahir"
                    >

                </div>


                <div class="form-group">

                    <label>Program Studi</label>

                    <select
                        name="id_prodi"
                        required
                    >

                        <option value="">
                            -- Pilih Program Studi --
                        </option>

                        <?php while ($prodi = mysqli_fetch_assoc($query_prodi)) { ?>

                            <option
                                value="<?php echo $prodi['id']; ?>"
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
                        placeholder="Contoh: 2026"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Nomor HP</label>

                    <input
                        type="text"
                        name="no_hp"
                        placeholder="Contoh: 081234567890"
                    >

                </div>


                <div class="form-group">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Contoh: mahasiswa@gmail.com"
                    >

                </div>


                <div class="form-group">

                    <label>Alamat</label>

                    <textarea
                        name="alamat"
                        placeholder="Masukkan alamat lengkap"
                    ></textarea>

                </div>


                <div class="form-group">

                    <label>Status</label>

                    <select
                        name="status"
                        required
                    >

                        <option value="Aktif">
                            Aktif
                        </option>

                        <option value="Cuti">
                            Cuti
                        </option>

                        <option value="Lulus">
                            Lulus
                        </option>

                        <option value="Nonaktif">
                            Nonaktif
                        </option>

                    </select>

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                        onclick="showSuccess()"
                    >
                        ✓ Simpan
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