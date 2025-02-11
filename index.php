    <?php
    include 'config.php';
    session_start();


    if (!isset($_SESSION['logged_in'])) {
        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['username'];
    $role = $_SESSION['role'];

    // Query untuk mendapatkan jumlah barang
    $queryBarang = "SELECT COUNT(*) as total_barang FROM produk";
    $resultBarang = mysqli_query($conn, $queryBarang);
    $rowBarang = mysqli_fetch_assoc($resultBarang);
    $totalBarang = $rowBarang['total_barang'];

    // Query untuk mendapatkan jumlah barang keluar
    $querySupplier = "SELECT * FROM pelanggan";
    $resultSupplier = mysqli_query($conn, $querySupplier);
    $totalSupplier = mysqli_num_rows($resultSupplier);

    // Query untuk mendapatkan jumlah user
    $queryUser = "SELECT COUNT(*) as total_user FROM user";
    $resultUser = mysqli_query($conn, $queryUser);
    $rowUser = mysqli_fetch_assoc($resultUser);
    $totalUser = $rowUser['total_user'];

    $queryTotalBarangMasuk = "SELECT COALESCE(SUM(JumlahProduk), 0) AS total_barang_masuk FROM detailpenjualan";
    $resultTotalBarangMasuk = mysqli_query($conn, $queryTotalBarangMasuk);
    $rowTotalBarangMasuk = mysqli_fetch_assoc($resultTotalBarangMasuk);
    $totalBarangMasuk = $rowTotalBarangMasuk['total_barang_masuk'];


    $query = "SELECT b.ProdukID, b.NamaProduk, b.Harga, 
           COALESCE(SUM(dp.JumlahProduk), 0) AS Stok 
    FROM produk b
    LEFT JOIN detailpenjualan dp ON b.ProdukID = dp.DetailID
    GROUP BY b.ProdukID, b.NamaProduk, b.Harga
";

    ?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            body {
                background-color: #1a1a1a;
                color: #ffffff;
                font-family: 'Poppins', sans-serif;
                display: flex;
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


            .sidebar {
                width: 250px;
                height: 100vh;
                position: fixed;
                background-color: rgb(0, 0, 0);
                padding-top: 20px;
            }

            .sidebar a {
                padding: 15px;
                text-decoration: none;
                font-size: 18px;
                color: white;
                display: block;
            }

            .sidebar a:hover {
                transition: 0.3s;
                color: red;
            }

            .content {
                margin-left: 260px;
                padding: 20px;
                width: 100%;
            }

            .menu-toggle {
                display: none;
                position: fixed;
                left: 10px;
                top: 10px;
                font-size: 24px;
                cursor: pointer;
                color: white;
                background: #343a40;
                padding: 5px 10px;
                border-radius: 5px;
            }

            .log {
                color: red;
                background-color: black;
                margin: 0px 50px 2px 50px;
                border-radius: 20px;
            }

            .log:hover {
                background-color: red;
                transition: 0.3s;
            }

            .container {
                display: flex;

            }

            .box {
                background-color: white;
                margin-right: 10px;
                display: flex;
                flex: 1;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            }

            @media (max-width: 768px) {
                .sidebar {
                    width: 0;
                    overflow: hidden;
                    transition: 0.3s;
                }

                .content {
                    margin-left: 0;
                }

                .menu-toggle {
                    display: block;
                }

                .sidebar.active {
                    width: 250px;
                }

            }
        </style>
    </head>

    <body>

        <div class="menu-toggle" onclick="toggleMenu()">☰</div>

        <div class="sidebar text-center">
            <img src="Eye of Horus (Persona 5) - __ XXVII_ Echo Across Dimensions __.gif" alt="" class="rounded mx-auto d-block w-100">
            <a href="index.php">Dashboard</a>
            <a href="barang.php">Kelola Barang</a>
            <a href="supplier.php">Kelola Supplier</a>
            <a href="penjualan.php">Kelola Pembelian</a>

            <?php if ($role == 'admin'): ?>
                <a href="register_staff.php">Tambah Staff</a>
            <?php endif; ?>

            <a href="logout.php" class="log text-light">Logout</a>
        </div>

        <div class="content">
            <h2 class="text-center py-5">Dashboard - <?php echo ucfirst($role); ?></h2>
            <div class="container gap-5">
                <div class="box">
                    <div>
                        <lord-icon
                            src="https://cdn.lordicon.com/kezeezyg.json"
                            trigger="loop"
                            delay="100"
                            colors="primary:#121331,secondary:#911710"
                            style="width:90px;height:90px">

                        </lord-icon>

                    </div>
                    <div class="text-dark">
                        <p class="pt-2 px-2 fw-bold fs-6">Data Barang</p>
                        <span class="px-2 fw-bold"><?php echo $totalBarang; ?></span>
                    </div>
                </div>
                <div class="box">
                    <lord-icon
                        src="https://cdn.lordicon.com/tsrgicte.json"
                        trigger="loop"
                        delay="100"
                        colors="primary:#121331,secondary:#911710"
                        style="width:90px;height:90px">
                    </lord-icon>
                    <div class="text-dark">
                        <p class="pt-2 px-2 fw-bold fs-6">Barang Masuk</p>
                        <span class="px-2 fw-bold"><?php echo $totalBarangMasuk; ?></span>
                    </div>
                </div>
                <div class="box">
                    <lord-icon
                        src="https://cdn.lordicon.com/gwvmctbb.json"
                        trigger="loop"
                        delay="100"
                        colors="primary:#121331,secondary:#911710"
                        style="width:90px;height:90px">
                    </lord-icon>
                    <div class="text-dark">
                        <p class="pt-2 px-2 fw-bold fs-6">Supplier</p>
                        <span class="px-2 fw-bold"><?php echo $totalSupplier; ?></span>
                    </div>
                </div>
                <div class="box">
                    <lord-icon
                        src="https://cdn.lordicon.com/kdduutaw.json"
                        trigger="loop"
                        delay="100"
                        colors="primary:#121331,secondary:#911710"
                        style="width:90px;height:90px">
                    </lord-icon>
                    <div class="text-dark">
                        <p class="pt-2 px-2 fw-bold fs-6">Data User</p>
                        <span class="px-2 fw-bold"><?php echo $totalUser; ?></span>
                    </div>
                </div>
            </div>

            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, $query);
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['NamaProduk']}</td>
                            <td>Rp " . number_format($row['Harga'], 0, ',', '.') . "</td>
                            <td>{$row['Stok']}</td>
                                </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>

        </div>

        <script>
            function toggleMenu() {
                document.querySelector('.sidebar').classList.toggle('active');
            }
        </script>
        <script src="https://cdn.lordicon.com/lordicon.js"></script>

    </body>

    </html>