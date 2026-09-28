<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

$judul = "Detail Mahasiswa";

$id = $_GET['id'] ?? 0;


// Mengambil data mahasiswa
$query = mysqli_prepare(
    $koneksi,

    "SELECT
        mahasiswa.*,
        prodi.kode_prodi,
        prodi.nama_prodi,
        prodi.jenjang

    FROM mahasiswa

    INNER JOIN prodi
        ON mahasiswa.id_prodi = prodi.id

    WHERE mahasiswa.id = ?"
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

?>

<?php include "../template/header.php"; ?>

<?php include "../template/sidebar.php"; ?>

<div class="main-content">

    <?php include "../template/navbar.php"; ?>

    <div class="content">

        <div class="page-header">

            <div>

                <h1>Detail Mahasiswa</h1>

                <p>
                    Informasi lengkap mahasiswa
                </p>

            </div>

        </div>


        <div class="detail-card">

            <div class="detail-header">

                <h2>
                    <?php echo htmlspecialchars($data['nama']); ?>
                </h2>

                <span class="status-badge status-<?php echo strtolower($data['status']); ?>">

                    <?php echo htmlspecialchars($data['status']); ?>

                </span>

            </div>


            <div class="detail-grid">


                <div class="detail-item">

                    <span>NIM</span>

                    <strong>
                        <?php echo htmlspecialchars($data['nim']); ?>
                    </strong>

                </div>


                <div class="detail-item">

                    <span>Jenis Kelamin</span>

                    <strong>
                        <?php
                        echo htmlspecialchars(
                            $data['jenis_kelamin']
                        );
                        ?>
                    </strong>

                </div>


                <div class="detail-item">

                    <span>Tempat, Tanggal Lahir</span>

                    <strong>

                        <?php
                        echo htmlspecialchars(
                            $data['tempat_lahir']
                        );
                        ?>

                        ,

                        <?php

                        if (!empty($data['tanggal_lahir'])) {

                            echo date(
                                'd-m-Y',
                                strtotime(
                                    $data['tanggal_lahir']
                                )
                            );

                        }

                        ?>

                    </strong>

                </div>


                <div class="detail-item">

                    <span>Program Studi</span>

                    <strong>

                        <?php
                        echo htmlspecialchars(
                            $data['kode_prodi']
                        );
                        ?>

                        -

                        <?php
                        echo htmlspecialchars(
                            $data['nama_prodi']
                        );
                        ?>

                        (<?php echo $data['jenjang']; ?>)

                    </strong>

                </div>


                <div class="detail-item">

                    <span>Angkatan</span>

                    <strong>
                        <?php echo $data['angkatan']; ?>
                    </strong>

                </div>


                <div class="detail-item">

                    <span>No. HP</span>

                    <strong>
                        <?php
                        echo htmlspecialchars(
                            $data['no_hp']
                        );
                        ?>
                    </strong>

                </div>


                <div class="detail-item">

                    <span>Email</span>

                    <strong>
                        <?php
                        echo htmlspecialchars(
                            $data['email']
                        );
                        ?>
                    </strong>

                </div>


                <div class="detail-item detail-full">

                    <span>Alamat</span>

                    <strong>
                        <?php
                        echo nl2br(
                            htmlspecialchars(
                                $data['alamat']
                            )
                        );
                        ?>
                    </strong>

                </div>


            </div>


            <div class="form-actions">

                <a
                    href="edit.php?id=<?php echo $data['id']; ?>"
                    class="btn btn-warning"
                >
                    Edit Data
                </a>

                <a
                    href="index.php"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </div>

        </div>

    </div>

</div>

<?php include "../template/footer.php"; ?>