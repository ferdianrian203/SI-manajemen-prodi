<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$judul = "Tambah Program Studi";

?>

<?php include "../template/header.php"; ?>

<?php include "../template/sidebar.php"; ?>

<div class="main-content">

    <?php include "../template/navbar.php"; ?>

    <div class="content">

        <div class="page-header">

            <div>

                <h1>Tambah Program Studi</h1>

                <p>
                    Tambahkan program studi baru
                </p>

            </div>

        </div>


        <div class="form-container">

            <form
                action="proses_tambah.php"
                method="POST"
            >

                <div class="form-group">

                    <label>
                        Kode Program Studi
                    </label>

                    <input
                        type="text"
                        name="kode_prodi"
                        placeholder="Contoh: TI"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Nama Program Studi
                    </label>

                    <input
                        type="text"
                        name="nama_prodi"
                        placeholder="Contoh: Teknik Informatika"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Jenjang
                    </label>

                    <select name="jenjang" required>

                        <option value="">
                            -- Pilih Jenjang --
                        </option>

                        <option value="D3">
                            D3
                        </option>

                        <option value="D4">
                            D4
                        </option>

                        <option value="S1">
                            S1
                        </option>

                        <option value="S2">
                            S2
                        </option>

                        <option value="S3">
                            S3
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Keterangan
                    </label>

                    <textarea
                        name="keterangan"
                        placeholder="Masukkan keterangan jika diperlukan"
                    ></textarea>

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