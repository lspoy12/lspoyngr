<?php
include 'config.php';
include 'session_login.php';

// Tambah Penjualan
if (isset($_POST['tambah'])) {
    $TanggalPenjualan = $_POST['tanggal'];
    $PelangganID = $_POST['supplier_id'];
    $TotalHarga = 0; // Akan diperbarui setelah detail pembelian dimasukkan

    // Insert data penjualan
    $query = "INSERT INTO penjualan (TanggalPenjualan, PelangganID, TotalHarga) VALUES ('$TanggalPenjualan', '$PelangganID', '$TotalHarga')";
    mysqli_query($conn, $query);

    // Ambil PenjualanID yang baru saja ditambahkan
    $PenjualanID = mysqli_insert_id($conn);

    // Redirect ke halaman detail pembelian untuk menambah produk
    header("Location: detail_pembelian.php?pembelian_id=$PenjualanID");
    exit;
}

// Hapus Pembelian
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM penjualan WHERE PenjualanID='$id'");
    header("Location: penjualan.php");
}

// Ambil data penjualan dan pelanggan
$pembelian = mysqli_query($conn, "SELECT penjualan.*, pelanggan.NamaPelanggan AS pelanggan FROM penjualan JOIN pelanggan ON penjualan.PelangganID = pelanggan.PelangganID");
$suppliers = mysqli_query($conn, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembelian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            background-color: #2d2d2d;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #ff0000;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .btn-secondary {
            background-color: #4d4d4d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #666666;
        }

        .btn-primary {
            background-color: #ff0000;
            border: none;
        }

        .form-control {
            background-color: #333333;
            border: 1px solid #4d4d4d;
            color: #ffffff;
        }

        .form-control:focus {
            background-color: #404040;
            border-color: #ff0000;
            box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25);
            color: #ffffff;
        }

        .table {
            color: #ffffff;
            background-color: #2d2d2d;
        }

        .table thead th {
            background-color: rgb(255, 255, 255);
            border-color: rgb(255, 255, 255);
        }

        .table td {
            border-color: #4d4d4d;
        }

        .table tbody tr {
            background-color: #333333;
        }

        .table tbody tr:hover {
            background-color: #404040;
        }

        .btn-info {
            background-color: #404040;
            border: none;
            color: #ffffff;
        }

        .btn-info:hover {
            background-color: #ff0000;
            color: #ffffff;
        }

        .btn-danger {
            background-color: #800000;
            border: none;
        }

        .btn-danger:hover {
            background-color: #ff0000;
        }

        select option {
            background-color: #333333;
            color: #ffffff;
        }
    </style>

</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Kelola Pembelian</h2>
        <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Beranda</a>

        <!-- Form Tambah Pembelian -->
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Pelanggan</label>
                <select name="supplier_id" class="form-control" required>
                    <option value="">Pilih Pelanggan</option>
                    <?php while ($row = mysqli_fetch_assoc($suppliers)) : ?>
                        <option value="<?= $row['PelangganID'] ?>"><?= $row['NamaPelanggan'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah Pembelian</button>
        </form>

        <!-- Tabel Pembelian -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($pembelian)) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['TanggalPenjualan']}</td>
                        <td>{$row['pelanggan']}</td>
                        <td>Rp " . number_format($row['TotalHarga'], 0, ',', '.') . "</td>
                        <td>
                            <a href='detail_pembelian.php?pembelian_id={$row['PenjualanID']}' class='btn btn-info btn-sm'>Detail</a>
                            <a href='?hapus={$row['PenjualanID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                        </td>
                    </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
