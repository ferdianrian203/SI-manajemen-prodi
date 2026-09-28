<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

$judul = "Edit Program Studi";


// Mengambil ID dari URL
$id = $_GET['id'] ?? 0;


// Mengambil data berdasarkan ID
$query = mysqli_prepare(
    $koneksi,
    "SELECT * FROM prodi WHERE id = ?"
);

mysqli_stmt_bind_param(
    $query,
    "i",
    $id
);

mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);


// Jika data tidak ditemukan
if (mysqli_num_rows($result) == 0) {

    header("Location: index.php?pesan=gagal");
    exit;

}


$data = mysqli_fetch_assoc($result);

?>

<?php include "../template/header.php"; ?>

<?php include "../template/sidebar.php"; ?>

<div class="main-content">

    <?php include "../template/navbar.php"; ?>

    <div class="content">

        <div class="page-header">

            <div>

                <h1>Edit Program Studi</h1>

                <p>
                    Perbarui data program studi
                </p>

            </div>

        </div>


        <div class="form-container">

            <form
                action="proses_edit.php"
                method="POST"
            >

                <!-- ID disembunyikan -->
                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $data['id']; ?>"
                >


                <div class="form-group">

                    <label>
                        Kode Program Studi
                    </label>

                    <input
                        type="text"
                        name="kode_prodi"
                        value="<?php echo htmlspecialchars($data['kode_prodi']); ?>"
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
                        value="<?php echo htmlspecialchars($data['nama_prodi']); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Jenjang
                    </label>

                    <select name="jenjang" required>

                        <option value="D3"
                            <?php
                            if ($data['jenjang'] == 'D3') {
                                echo 'selected';
                            }
                            ?>
                        >
                            D3
                        </option>

                        <option value="D4"
                            <?php
                            if ($data['jenjang'] == 'D4') {
                                echo 'selected';
                            }
                            ?>
                        >
                            D4
                        </option>

                        <option value="S1"
                            <?php
                            if ($data['jenjang'] == 'S1') {
                                echo 'selected';
                            }
                            ?>
                        >
                            S1
                        </option>

                        <option value="S2"
                            <?php
                            if ($data['jenjang'] == 'S2') {
                                echo 'selected';
                            }
                            ?>
                        >
                            S2
                        </option>

                        <option value="S3"
                            <?php
                            if ($data['jenjang'] == 'S3') {
                                echo 'selected';
                            }
                            ?>
                        >
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
                    ><?php echo htmlspecialchars($data['keterangan']); ?></textarea>

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