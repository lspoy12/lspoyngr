<?php
include 'config.php';
include 'session_login.php';

// Tambah Supplier
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nomor = $_POST['nomor'];

    $query = "INSERT INTO pelanggan (NamaPelanggan, Alamat, NomorTelepon) VALUES ('$nama', '$alamat', '$nomor')";
    mysqli_query($conn, $query);
    header("Location: supplier.php");
}

// Hapus Supplier
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM supplier WHERE id='$id'");
    header("Location: supplier.php");
}

// Edit Supplier
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nomor = $_POST['nomor'];

    $query = "UPDATE supplier SET nama='$nama', alamat='$alamat', nomor='$nomor' WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: supplier.php");
}

$supplier = mysqli_query($conn, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Supplier</title>
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
        <h2 class="text-center">Kelola Supplier</h2>
        <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Beranda</a>

        <!-- Form Tambah Supplier -->
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label>Nama Supplier</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nomor Telepon</label>
                <input type="text" name="nomor" class="form-control" required>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah Supplier</button>
        </form>

        <!-- Tabel Supplier -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($supplier)) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['NamaPelanggan']}</td>
                        <td>{$row['Alamat']}</td>
                        <td>{$row['NomorTelepon']}</td>
                        <td>
                            <a href='?hapus={$row['PelangganID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal{$row['PelangganID']}'>Edit</button>

                            <!-- Modal Edit -->
                            <div class='modal fade' id='editModal{$row['PelangganID']}' tabindex='-1'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Edit Supplier</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='POST'>
                                                <input type='hidden' name='PelangganID' value='{$row['PelangganID']}'>
                                                <div class='mb-3'>
                                                    <label>Nama Supplier</label>
                                                    <input type='text' name='nama' class='form-control' value='{$row['NamaPelanggan']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>Alamat</label>
                                                    <input type='text' name='alamat' class='form-control' value='{$row['Alamat']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>Nomor Telepon</label>
                                                    <input type='text' name='nomor' class='form-control' value='{$row['NomorTelepon']}' required>
                                                </div>
                                                <button type='submit' name='edit' class='btn btn-success'>Simpan Perubahan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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