<?php
include 'config.php';
session_start();

// if (!isset($_SESSION['logged_in']) || $_SESSION['role'] ! 'staff') {
//     header("Location: index.php");
//     exit();
// }

// Tambah barang
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $query = "INSERT INTO produk (NamaProduk, Harga, Stok) VALUES ('$nama', '$harga', '$stok')";
    mysqli_query($conn, $query);
    header("Location: barang.php");
    exit();
}

// Hapus barang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM produk WHERE ProdukID = $id";
    mysqli_query($conn, $query);
    header("Location: barang.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang</title>
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
            background-color: rgb(255, 255, 255);
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Kelola Barang</h2>
        <form method="POST" class="formini">
            <div class="mb-3">
                <label class="py-1 px-1">Nama Barang</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required>
            </div>
            <div class="mb-3">
                <label class="py-1 px-1">Harga</label>
                <input type="number" name="harga" class="form-control" placeholder="Harga" required>
            </div>
            <!-- <div class="mb-3">
                <input type="number" name="stok" class="form-control" placeholder="Stok" required>
            </div> -->
            <button type="submit" name="tambah" class="btn btn-primary">Tambah Barang</button>
        </form>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <!-- <th>Stok</th> -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM produk";
                $result = mysqli_query($conn, $query);
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['NamaProduk']}</td>
                        <td>Rp " . number_format($row['Harga'], 0, ',', '.') . "</td>
                        <td>
                            <a href='barang.php?hapus={$row['ProdukID']}' class='btn btn-danger'>Hapus</a>
                        </td>
                    </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>

</html>