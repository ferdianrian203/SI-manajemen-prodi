<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

/* =====================================================
   1. TOTAL PROGRAM STUDI
===================================================== */

$query_prodi = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM prodi");
$data_prodi = mysqli_fetch_assoc($query_prodi);

$total_prodi = $data_prodi['total'];


/* =====================================================
   2. TOTAL MAHASISWA
===================================================== */

$query_mahasiswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM mahasiswa");
$data_mahasiswa = mysqli_fetch_assoc($query_mahasiswa);

$total_mahasiswa = $data_mahasiswa['total'];


/* =====================================================
   3. MAHASISWA AKTIF
===================================================== */

$query_aktif = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM mahasiswa WHERE status = 'Aktif'"
);

$data_aktif = mysqli_fetch_assoc($query_aktif);

$total_aktif = $data_aktif['total'];


/* =====================================================
   4. MAHASISWA CUTI
===================================================== */

$query_cuti = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM mahasiswa WHERE status = 'Cuti'"
);

$data_cuti = mysqli_fetch_assoc($query_cuti);

$total_cuti = $data_cuti['total'];


/* =====================================================
   5. MAHASISWA LULUS
===================================================== */

$query_lulus = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM mahasiswa WHERE status = 'Lulus'"
);

$data_lulus = mysqli_fetch_assoc($query_lulus);

$total_lulus = $data_lulus['total'];


/* =====================================================
   6. MAHASISWA NONAKTIF
===================================================== */

$query_nonaktif = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM mahasiswa WHERE status = 'Nonaktif'"
);

$data_nonaktif = mysqli_fetch_assoc($query_nonaktif);

$total_nonaktif = $data_nonaktif['total'];


/* =====================================================
   7. MAHASISWA PER PROGRAM STUDI
===================================================== */

$query_per_prodi = mysqli_query(
    $koneksi,
    "SELECT
        prodi.nama_prodi,
        prodi.kode_prodi,
        COUNT(mahasiswa.id) AS total_mahasiswa
     FROM prodi
     LEFT JOIN mahasiswa
        ON prodi.id = mahasiswa.id_prodi
     GROUP BY prodi.id
     ORDER BY total_mahasiswa DESC"
);


/* =====================================================
   8. MAHASISWA PER ANGKATAN
===================================================== */

$query_per_angkatan = mysqli_query(
    $koneksi,
    "SELECT
        angkatan,
        COUNT(*) AS total_mahasiswa
     FROM mahasiswa
     GROUP BY angkatan
     ORDER BY angkatan DESC"
);


/* =====================================================
   9. MAHASISWA TERBARU
===================================================== */

$query_terbaru = mysqli_query(
    $koneksi,
    "SELECT
        mahasiswa.nim,
        mahasiswa.nama,
        mahasiswa.angkatan,
        mahasiswa.status,
        prodi.nama_prodi
     FROM mahasiswa
     INNER JOIN prodi
        ON mahasiswa.id_prodi = prodi.id
     ORDER BY mahasiswa.id DESC
     LIMIT 10"
);

?>

<?php include "../template/header.php"; ?>

<?php include "../template/navbar.php"; ?>

<?php include "../template/sidebar.php"; ?>


<div class="main-content">

    <!-- HEADER DASHBOARD -->
    <div class="dashboard-header">

        <div>
            <h1>Dashboard</h1>

            <p>
                Sistem Informasi Manajemen Mahasiswa
            </p>
        </div>

    </div>


    <!-- =================================================
         KARTU STATISTIK
    ================================================== -->

    <div class="statistik-grid">

        <!-- TOTAL PRODI -->
        <div class="statistik-card">

            <div class="statistik-icon">
                🎓
            </div>

            <div class="statistik-info">

                <h3>
                    <?php echo $total_prodi; ?>
                </h3>

                <p>
                    Program Studi
                </p>

            </div>

        </div>


        <!-- TOTAL MAHASISWA -->
        <div class="statistik-card">

            <div class="statistik-icon">
                👨‍🎓
            </div>

            <div class="statistik-info">

                <h3>
                    <?php echo $total_mahasiswa; ?>
                </h3>

                <p>
                    Total Mahasiswa
                </p>

            </div>

        </div>


        <!-- AKTIF -->
        <div class="statistik-card">

            <div class="statistik-icon">
                ✅
            </div>

            <div class="statistik-info">

                <h3>
                    <?php echo $total_aktif; ?>
                </h3>

                <p>
                    Mahasiswa Aktif
                </p>

            </div>

        </div>


        <!-- CUTI -->
        <div class="statistik-card">

            <div class="statistik-icon">
                ⏸️
            </div>

            <div class="statistik-info">

                <h3>
                    <?php echo $total_cuti; ?>
                </h3>

                <p>
                    Mahasiswa Cuti
                </p>

            </div>

        </div>


        <!-- LULUS -->
        <div class="statistik-card">

            <div class="statistik-icon">
                🎓
            </div>

            <div class="statistik-info">

                <h3>
                    <?php echo $total_lulus; ?>
                </h3>

                <p>
                    Mahasiswa Lulus
                </p>

            </div>

        </div>


        <!-- NONAKTIF -->
        <div class="statistik-card">

            <div class="statistik-icon">
                ⚠️
            </div>

            <div class="statistik-info">

                <h3>
                    <?php echo $total_nonaktif; ?>
                </h3>

                <p>
                    Mahasiswa Nonaktif
                </p>

            </div>

        </div>

    </div>


    <!-- =================================================
         STATISTIK PRODI & ANGKATAN
    ================================================== -->

    <div class="dashboard-grid">


        <!-- MAHASISWA PER PRODI -->
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <h2>
                    Mahasiswa Per Program Studi
                </h2>

            </div>


            <div class="table-responsive">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Program Studi</th>

                            <th>Jumlah</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php

                        $no = 1;

                        if (mysqli_num_rows($query_per_prodi) > 0) {

                            while ($prodi = mysqli_fetch_assoc($query_per_prodi)) {

                        ?>

                        <tr>

                            <td>
                                <?php echo $no++; ?>
                            </td>

                            <td>

                                <strong>
                                    <?php echo htmlspecialchars($prodi['nama_prodi']); ?>
                                </strong>

                                <br>

                                <small>
                                    <?php echo htmlspecialchars($prodi['kode_prodi']); ?>
                                </small>

                            </td>

                            <td>

                                <span class="jumlah-mahasiswa">

                                    <?php echo $prodi['total_mahasiswa']; ?>

                                    mahasiswa

                                </span>

                            </td>

                        </tr>

                        <?php

                            }

                        } else {

                        ?>

                        <tr>

                            <td colspan="3" style="text-align:center;">

                                Belum ada data program studi.

                            </td>

                        </tr>

                        <?php

                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>



        <!-- MAHASISWA PER ANGKATAN -->
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <h2>
                    Mahasiswa Per Angkatan
                </h2>

            </div>


            <div class="table-responsive">

                <table>

                    <thead>

                        <tr>

                            <th>Angkatan</th>

                            <th>Jumlah Mahasiswa</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php

                        if (mysqli_num_rows($query_per_angkatan) > 0) {

                            while ($angkatan = mysqli_fetch_assoc($query_per_angkatan)) {

                        ?>

                        <tr>

                            <td>

                                <strong>
                                    <?php echo $angkatan['angkatan']; ?>
                                </strong>

                            </td>

                            <td>

                                <div class="progress-container">

                                    <?php

                                    if ($total_mahasiswa > 0) {

                                        $persentase =
                                            ($angkatan['total_mahasiswa'] / $total_mahasiswa) * 100;

                                    } else {

                                        $persentase = 0;

                                    }

                                    ?>

                                    <div class="progress-bar">

                                        <div
                                            class="progress-fill"
                                            style="width: <?php echo $persentase; ?>%;"
                                        >
                                        </div>

                                    </div>

                                    <span>

                                        <?php echo $angkatan['total_mahasiswa']; ?>

                                    </span>

                                </div>

                            </td>

                        </tr>

                        <?php

                            }

                        } else {

                        ?>

                        <tr>

                            <td colspan="2" style="text-align:center;">

                                Belum ada data mahasiswa.

                            </td>

                        </tr>

                        <?php

                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    <!-- =================================================
         STATUS MAHASISWA
    ================================================== -->

    <div class="dashboard-card status-dashboard">

        <div class="dashboard-card-header">

            <h2>
                Statistik Status Mahasiswa
            </h2>

        </div>


        <div class="status-grid">


            <!-- AKTIF -->

            <div class="status-stat">

                <div class="status-circle aktif">

                    <?php echo $total_aktif; ?>

                </div>

                <h3>
                    Aktif
                </h3>

                <?php

                if ($total_mahasiswa > 0) {

                    $persentase_aktif =
                        ($total_aktif / $total_mahasiswa) * 100;

                } else {

                    $persentase_aktif = 0;

                }

                ?>

                <p>
                    <?php echo number_format($persentase_aktif, 1); ?>%
                </p>

            </div>



            <!-- CUTI -->

            <div class="status-stat">

                <div class="status-circle cuti">

                    <?php echo $total_cuti; ?>

                </div>

                <h3>
                    Cuti
                </h3>

                <?php

                if ($total_mahasiswa > 0) {

                    $persentase_cuti =
                        ($total_cuti / $total_mahasiswa) * 100;

                } else {

                    $persentase_cuti = 0;

                }

                ?>

                <p>
                    <?php echo number_format($persentase_cuti, 1); ?>%
                </p>

            </div>



            <!-- LULUS -->

            <div class="status-stat">

                <div class="status-circle lulus">

                    <?php echo $total_lulus; ?>

                </div>

                <h3>
                    Lulus
                </h3>

                <?php

                if ($total_mahasiswa > 0) {

                    $persentase_lulus =
                        ($total_lulus / $total_mahasiswa) * 100;

                } else {

                    $persentase_lulus = 0;

                }

                ?>

                <p>
                    <?php echo number_format($persentase_lulus, 1); ?>%
                </p>

            </div>



            <!-- NONAKTIF -->

            <div class="status-stat">

                <div class="status-circle nonaktif">

                    <?php echo $total_nonaktif; ?>

                </div>

                <h3>
                    Nonaktif
                </h3>

                <?php

                if ($total_mahasiswa > 0) {

                    $persentase_nonaktif =
                        ($total_nonaktif / $total_mahasiswa) * 100;

                } else {

                    $persentase_nonaktif = 0;

                }

                ?>

                <p>
                    <?php echo number_format($persentase_nonaktif, 1); ?>%
                </p>

            </div>


        </div>

    </div>



    <!-- =================================================
         MAHASISWA TERBARU
    ================================================== -->

    <div class="dashboard-card">

        <div class="dashboard-card-header">

            <h2>
                Data Mahasiswa Terbaru
            </h2>

            <a
                href="../mahasiswa/index.php"
                class="btn-primary::content"
            >
                Lihat Semua
            </a>

        </div>


        <div class="table-responsive">

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>NIM</th>

                        <th>Nama</th>

                        <th>Program Studi</th>

                        <th>Angkatan</th>

                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    $no = 1;

                    if (mysqli_num_rows($query_terbaru) > 0) {

                        while ($mhs = mysqli_fetch_assoc($query_terbaru)) {

                    ?>

                    <tr>

                        <td>
                            <?php echo $no++; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($mhs['nim']); ?>
                        </td>

                        <td>

                            <strong>

                                <?php
                                echo htmlspecialchars($mhs['nama']);
                                ?>

                            </strong>

                        </td>

                        <td>

                            <?php
                            echo htmlspecialchars($mhs['nama_prodi']);
                            ?>

                        </td>

                        <td>
                            <?php echo $mhs['angkatan']; ?>
                        </td>

                        <td>

                            <?php

                            if ($mhs['status'] == 'Aktif') {

                                echo '<span class="status-badge status-aktif">Aktif</span>';

                            } elseif ($mhs['status'] == 'Cuti') {

                                echo '<span class="status-badge status-cuti">Cuti</span>';

                            } elseif ($mhs['status'] == 'Lulus') {

                                echo '<span class="status-badge status-lulus">Lulus</span>';

                            } else {

                                echo '<span class="status-badge status-nonaktif">Nonaktif</span>';

                            }

                            ?>

                        </td>

                    </tr>

                    <?php

                        }

                    } else {

                    ?>

                    <tr>

                        <td
                            colspan="6"
                            style="text-align:center;"
                        >

                            Belum ada data mahasiswa.

                        </td>

                    </tr>

                    <?php

                    }

                    ?>

                </tbody>

            </table>

        </div>

    </div>


</div>


<?php include "../template/footer.php"; ?>