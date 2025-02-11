<?php
session_start();
include 'config.php';

$produk = mysqli_query($conn, "SELECT * FROM produk");  // Mengambil data produk
$detail_penjualan = mysqli_query($conn, "
    SELECT detailpenjualan.*, produk.NamaProduk AS produk 
    FROM detailpenjualan 
    JOIN produk ON detailpenjualan.ProdukID = produk.ProdukID 
    WHERE PenjualanID='$penjualan_id'
");

// Tambah Detail Penjualan
if (isset($_POST['tambah'])) {
    $produk_id = $_POST['produk_id'];  // Menggunakan produk_id
    $jumlah = $_POST['jumlah'];
    $harga_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Harga FROM produk WHERE ProdukID='$produk_id'"))['Harga'];
    $sub_total = $harga_produk * $jumlah;

    // Pastikan PenjualanID ada sebelum insert
    mysqli_query($conn, "INSERT INTO detailpenjualan (PenjualanID, ProdukID, JumlahProduk, Subtotal) 
                        VALUES ('$penjualan_id', '$produk_id', '$jumlah', '$sub_total')");
    mysqli_query($conn, "UPDATE penjualan SET TotalHarga = TotalHarga + $sub_total WHERE PenjualanID='$penjualan_id'");
    header("Location: detail_penjualan.php?penjualan_id=$penjualan_id");
}

// Hapus Detail Penjualan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Subtotal FROM detailpenjualan WHERE DetailID='$id'"));
    mysqli_query($conn, "DELETE FROM detailpenjualan WHERE DetailID='$id'");
    mysqli_query($conn, "UPDATE penjualan SET TotalHarga = TotalHarga - {$row['Subtotal']} WHERE PenjualanID='$penjualan_id'");
    header("Location: detail_penjualan.php?penjualan_id=$penjualan_id");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #1a1a1a;
                color: #ffffff;
            }
            .container {
                background-color: #2d2d2d;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.3);
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
            .btn-primary:hover {
                background-color: #cc0000;
            }
            .btn-danger {
                background-color: #800000;
                border: none;
            }
            .btn-danger:hover {
                background-color: #660000;
            }
            .form-control {
                background-color: #404040;
                border-color: #ff0000;
                box-shadow: 0 0 0 0.25rem rgba(255,0,0,0.25);
                color: #ffffff;
            }
            .form-control:focus {
                background-color: #404040;
                border-color: #ff0000;
                box-shadow: 0 0 0 0.25rem rgba(255,0,0,0.25);
                color: #ffffff;
            }
            .table {
                color: #ffffff;
            }
            .table thead {
                background-color: #ff0000;
                color: #ffffff;
            }
            .table tbody tr {
                background-color: #333333;
            }
            .table tbody tr:hover {
                background-color: #404040;
            }
            select option {
                background-color: #333333;
                color: #ffffff;
            }
            label {
                color: #ff0000;
                font-weight: 500;
            }
        </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Detail Penjualan</h2>
        <p><strong>Tanggal:</strong> <?= $penjualan['TanggalPenjualan'] ?></p>
        <a href="penjualan.php" class="btn btn-secondary mb-3">Kembali</a>

        <!-- Form Tambah Produk ke Penjualan -->
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label>Pilih Produk</label>
                <select name="produk_id" class="form-control" required>
                    <option value="">Pilih Produk</option>
                    <?php while ($row = mysqli_fetch_assoc($produk)) : ?>
                        <option value="<?= $row['ProdukID'] ?>"><?= $row['NamaProduk'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
        </form>

        <!-- Tabel Detail Penjualan -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($detail_penjualan)) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['produk']}</td>
                        <td>{$row['JumlahProduk']}</td>
                        <td>Rp " . number_format($row['Subtotal'], 0, ',', '.') . "</td>
                        <td><a href='?penjualan_id=$penjualan_id&hapus={$row['DetailID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus produk ini?\")'>Hapus</a></td>
                    </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
