
<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "tesujian1";

$conn = mysqli_connect($host, $user, $pass, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>
