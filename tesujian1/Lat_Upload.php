
<?php
include "Lat_Connect.php";

if (isset($_POST['upload'])) {

    $namaFile = $_FILES['Gambar']['name'];
    $tmpFile = $_FILES['Gambar']['tmp_name'];
    $ukuran = $_FILES['Gambar']['size'];

    $ekstensi = strtolower(
        pathinfo($namaFile, PATHINFO_EXTENSION)
    );

    $format = ['jpg', 'jpeg', 'png'];

    if ($_FILES['Gambar']['error'] !== UPLOAD_ERR_OK) {
        die("Gagal mengupload gambar.");

    } elseif (!in_array($ekstensi, $format)) {
        die("Format gambar harus JPG atau PNG.");

    } elseif ($ukuran > 2 * 1024 * 1024) {
        die("Ukuran gambar maksimal 2 MB.");

    } elseif (getimagesize($tmpFile) === false) {
        die("File bukan gambar yang valid.");
    }

    // Folder penyimpanan gambar
    $folder = __DIR__ . "/Gambar/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // Membuat nama file baru
    $namaBaru = uniqid("gambar_") . "." . $ekstensi;

    // Memindahkan gambar
    if (move_uploaded_file($tmpFile, $folder . $namaBaru)) {

        echo "Gambar berhasil diupload!<br>";
        echo "Nama gambar: " . htmlspecialchars($namaBaru);

    } else {
        echo "Gambar gagal diupload.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Gambar</title>
</head>
<body>

<h2>Upload Gambar Produk</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Pilih Gambar:</label>
    <input type="file" name="Gambar" accept=".jpg,.jpeg,.png" required>

    <br><br>

    <button type="submit" name="upload">Upload</button>

    <a href="Index.php">Kembali</a>

</form>

</body>
</html>
