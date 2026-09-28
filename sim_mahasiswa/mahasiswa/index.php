<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

$judul = "Data Mahasiswa";


// ================================
// PENCARIAN
// ================================

$cari = $_GET['cari'] ?? '';

$id_prodi = $_GET['id_prodi'] ?? '';

$status = $_GET['status'] ?? '';


// ================================
// PAGINATION
// ================================

$batas = 10;

$halaman = isset($_GET['halaman'])
    ? (int)$_GET['halaman']
    : 1;

if ($halaman < 1) {
    $halaman = 1;
}

$mulai = ($halaman - 1) * $batas;


// ================================
// QUERY DATA
// ================================

$where = [];

$params = [];
$types = "";


// Pencarian
if ($cari != '') {

    $where[] = "(mahasiswa.nim LIKE ? OR mahasiswa.nama LIKE ?)";

    $keyword = "%" . $cari . "%";

    $params[] = $keyword;
    $params[] = $keyword;

    $types .= "ss";
}


// Filter prodi
if ($id_prodi != '') {

    $where[] = "mahasiswa.id_prodi = ?";

    $params[] = $id_prodi;

    $types .= "i";
}


// Filter status
if ($status != '') {

    $where[] = "mahasiswa.status = ?";

    $params[] = $status;

    $types .= "s";
}


$where_sql = "";

if (count($where) > 0) {

    $where_sql = "WHERE " . implode(" AND ", $where);

}


// ================================
// TOTAL DATA
// ================================

$sql_total = "
    SELECT COUNT(*) AS total
    FROM mahasiswa
    $where_sql
";

$stmt_total = mysqli_prepare(
    $koneksi,
    $sql_total
);

if (!empty($params)) {

    mysqli_stmt_bind_param(
        $stmt_total,
        $types,
        ...$params
    );

}

mysqli_stmt_execute($stmt_total);

$result_total = mysqli_stmt_get_result($stmt_total);

$data_total = mysqli_fetch_assoc($result_total);

$total_data = $data_total['total'];

$total_halaman = ceil($total_data / $batas);


// ================================
// DATA MAHASISWA
// ================================

$sql = "
    SELECT
        mahasiswa.*,
        prodi.kode_prodi,
        prodi.nama_prodi,
        prodi.jenjang

    FROM mahasiswa

    INNER JOIN prodi
        ON mahasiswa.id_prodi = prodi.id

    $where_sql

    ORDER BY mahasiswa.nama ASC

    LIMIT ?, ?
";


$params_data = $params;

$types_data = $types . "ii";

$params_data[] = $mulai;
$params_data[] = $batas;


$stmt = mysqli_prepare(
    $koneksi,
    $sql
);

mysqli_stmt_bind_param(
    $stmt,
    $types_data,
    ...$params_data
);

mysqli_stmt_execute($stmt);

$query = mysqli_stmt_get_result($stmt);


// ================================
// DATA PROGRAM STUDI
// ================================

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


        <!-- HEADER -->

        <div class="page-header">

            <div>

                <h1>Data Mahasiswa</h1>

                <p>
                    Kelola data mahasiswa berdasarkan program studi
                </p>

            </div>

            <a
                href="tambah.php"
                class="btn btn-primary"
            >
                + Tambah Mahasiswa
            </a>

        </div>


        <!-- PESAN -->

        <?php if (isset($_GET['pesan'])) { ?>

            <?php if ($_GET['pesan'] == 'tambah') { ?>

                <div class="alert alert-success">
                    Data mahasiswa berhasil ditambahkan.
                </div>

            <?php } ?>

            <?php if ($_GET['pesan'] == 'edit') { ?>

                <div class="alert alert-success">
                    Data mahasiswa berhasil diperbarui.
                </div>

            <?php } ?>

            <?php if ($_GET['pesan'] == 'hapus') { ?>

                <div class="alert alert-success">
                    Data mahasiswa berhasil dihapus.
                </div>

            <?php } ?>

            <?php if ($_GET['pesan'] == 'gagal') { ?>

                <div class="alert alert-danger">
                    Proses data mahasiswa gagal.
                </div>

            <?php } ?>

        <?php } ?>


        <!-- FILTER -->

        <div class="filter-container">

            <form method="GET">

                <div class="filter-grid">


                    <div>

                        <label>
                            Cari Mahasiswa
                        </label>

                        <input
                            type="text"
                            name="cari"
                            value="<?php echo htmlspecialchars($cari); ?>"
                            placeholder="NIM atau nama mahasiswa"
                        >

                    </div>


                    <div>

                        <label>
                            Program Studi
                        </label>

                        <select name="id_prodi">

                            <option value="">
                                Semua Program Studi
                            </option>

                            <?php while ($prodi = mysqli_fetch_assoc($query_prodi)) { ?>

                                <option
                                    value="<?php echo $prodi['id']; ?>"
                                    <?php
                                    if ($id_prodi == $prodi['id']) {
                                        echo 'selected';
                                    }
                                    ?>
                                >

                                    <?php
                                    echo htmlspecialchars(
                                        $prodi['nama_prodi']
                                    );
                                    ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <div>

                        <label>
                            Status
                        </label>

                        <select name="status">

                            <option value="">
                                Semua Status
                            </option>

                            <option
                                value="Aktif"
                                <?php
                                if ($status == 'Aktif') {
                                    echo 'selected';
                                }
                                ?>
                            >
                                Aktif
                            </option>

                            <option
                                value="Cuti"
                                <?php
                                if ($status == 'Cuti') {
                                    echo 'selected';
                                }
                                ?>
                            >
                                Cuti
                            </option>

                            <option
                                value="Lulus"
                                <?php
                                if ($status == 'Lulus') {
                                    echo 'selected';
                                }
                                ?>
                            >
                                Lulus
                            </option>

                            <option
                                value="Nonaktif"
                                <?php
                                if ($status == 'Nonaktif') {
                                    echo 'selected';
                                }
                                ?>
                            >
                                Nonaktif
                            </option>

                        </select>

                    </div>


                    <div class="filter-button">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Cari
                        </button>

                        <a
                            href="index.php"
                            class="btn btn-secondary"
                        >
                            Reset
                        </a>

                    </div>


                </div>

            </form>

        </div>


        <!-- TABEL -->

        <div class="table-container">

            <div class="table-header">

                <h3>
                    Daftar Mahasiswa
                </h3>

                <p>
                    Total:
                    <strong>
                        <?php echo $total_data; ?>
                    </strong>
                    mahasiswa
                </p>

            </div>


            <div style="overflow-x:auto;">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>NIM</th>

                            <th>Nama</th>

                            <th>Jenis Kelamin</th>

                            <th>Program Studi</th>

                            <th>Angkatan</th>

                            <th>Status</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $no = $mulai + 1;

                    while ($data = mysqli_fetch_assoc($query)) {

                    ?>

                        <tr>

                            <td>
                                <?php echo $no++; ?>
                            </td>

                            <td>
                                <strong>
                                    <?php
                                    echo htmlspecialchars(
                                        $data['nim']
                                    );
                                    ?>
                                </strong>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $data['nama']
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $data['jenis_kelamin']
                                );
                                ?>
                            </td>

                            <td>

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

                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $data['angkatan']
                                );
                                ?>
                            </td>

                            <td>

                                <span class="status-badge status-<?php echo strtolower($data['status']); ?>">

                                    <?php
                                    echo htmlspecialchars(
                                        $data['status']
                                    );
                                    ?>

                                </span>

                            </td>

                            <td>

                                <a
                                    href="detail.php?id=<?php echo $data['id']; ?>"
                                    class="btn btn-info"
                                >
                                    Detail
                                </a>

                                <a
                                    href="edit.php?id=<?php echo $data['id']; ?>"
                                    class="btn btn-warning"
                                >
                                    Edit
                                </a>

                                <a
                                    href="hapus.php?id=<?php echo $data['id']; ?>"
                                    class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')"
                                >
                                    Hapus
                                </a>

                            </td>

                        </tr>

                    <?php } ?>


                    <?php if (mysqli_num_rows($query) == 0) { ?>

                        <tr>

                            <td
                                colspan="8"
                                style="text-align:center;"
                            >
                                Data mahasiswa tidak ditemukan.
                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>


            <!-- PAGINATION -->

            <?php if ($total_halaman > 1) { ?>

                <div class="pagination">

                    <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>

                        <?php

                        $parameter = http_build_query([
                            'halaman' => $i,
                            'cari' => $cari,
                            'id_prodi' => $id_prodi,
                            'status' => $status
                        ]);

                        ?>

                        <a
                            href="?<?php echo $parameter; ?>"
                            class="<?php echo ($i == $halaman) ? 'active' : ''; ?>"
                        >
                            <?php echo $i; ?>
                        </a>

                    <?php } ?>

                </div>

            <?php } ?>


        </div>

    </div>

</div>

<?php include "../template/footer.php"; ?>