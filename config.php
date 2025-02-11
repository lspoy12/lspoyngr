<?php
$host = "127.0.0.1";
$user = "root"; // Ganti dengan username MySQL Anda
$pass = ""; // Ganti dengan password MySQL Anda
$db = "kasir";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>