
<?php
include "Lat_Connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST['Nama'];
    $harga = $_POST['Harga'];
    $deskripsi = $_POST['Deskripsi'];

    // Memeriksa apakah gambar diunggah
    if (!isset($_FILES['Gambar']) ||
        $_FILES['Gambar']['error'] != 0) {
        die("Gambar gagal diunggah!");
    }

    // Memeriksa ukuran dan format gambar
    $gambar = $_FILES['Gambar'];
    $ukuran = $gambar['size'];
    $tmp = $gambar['tmp_name'];

    $info = getimagesize($tmp);

    if ($info === false) {
        die("File bukan gambar yang valid!");
    }

    if ($ukuran > 2 * 1024 * 1024) {
        die("Ukuran gambar maksimal 2 MB!");
    }

    $mime = $info['mime'];

    $format = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png'
    ];

    if (!isset($format[$mime])) {
        die("Format gambar harus JPG, JPEG, atau PNG!");
    }

    // Membuat folder uploads jika belum ada
    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    // Membuat nama file gambar
    $nama_gambar = uniqid() . "." . $format[$mime];

    $lokasi = "uploads/" . $nama_gambar;

    // Memindahkan gambar ke folder uploads
    if (!move_uploaded_file($tmp, $lokasi)) {
        die("Gagal menyimpan gambar!");
    }

    // Menyimpan data ke database
    $sql = "INSERT INTO sijaujian
            (Nama, Harga, Deskripsi, Gambar)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "siss",
        $nama,
        $harga,
        $deskripsi,
        $nama_gambar
    );

    if (mysqli_stmt_execute($stmt)) {
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Produk Berhasil Ditambahkan | Ken Marketplace</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'DM Sans', sans-serif;
    background: #f1f5f9;
    color: #172033;
    min-height: 100vh;
}

/* HEADER */

header {
    background: #101c35;
    padding: 19px 8%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 5px 25px rgba(15,23,42,0.12);
}

.logo {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 23px;
    font-weight: 800;
    color: white;
    letter-spacing: -0.7px;
}

.logo span {
    color: #38bdf8;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #cbd5e1;
    font-size: 12px;
}

.header-dot {
    width: 8px;
    height: 8px;
    background: #4ade80;
    border-radius: 50%;
    box-shadow: 0 0 10px #4ade80;
}

/* MAIN */

.container {
    max-width: 850px;
    margin: 55px auto;
    padding: 0 22px;
}

/* SUCCESS CARD */

.success-card {
    background: white;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(15,23,42,0.07);
    animation: fadeIn 0.7s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* SUCCESS HERO */

.hero {
    background:
        radial-gradient(circle at 90% 10%, #38bdf830, transparent 35%),
        linear-gradient(135deg, #101c35, #164e8a);
    padding: 45px 30px 40px;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.hero::before {
    content: "";
    position: absolute;
    width: 180px;
    height: 180px;
    border: 1px solid #ffffff15;
    border-radius: 50%;
    top: -90px;
    left: -55px;
}

.hero::after {
    content: "";
    position: absolute;
    width: 230px;
    height: 230px;
    border: 1px solid #ffffff15;
    border-radius: 50%;
    bottom: -160px;
    right: -65px;
}

/* CHECK ANIMATION */

.check-circle {
    width: 88px;
    height: 88px;
    background: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 23px;
    box-shadow: 0 8px 30px #00000020;
    position: relative;
    z-index: 1;
    animation: pop 0.65s cubic-bezier(.18,.89,.32,1.4);
}

.check-circle span {
    color: #16a34a;
    font-size: 46px;
    font-weight: 800;
}

@keyframes pop {
    0% {
        transform: scale(0);
    }
    80% {
        transform: scale(1.15);
    }
    100% {
        transform: scale(1);
    }
}

.hero h1 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 27px;
    font-weight: 800;
    margin-bottom: 12px;
    position: relative;
    z-index: 1;
}

.hero p {
    color: #dbeafe;
    font-size: 14px;
    line-height: 1.8;
    max-width: 460px;
    margin: auto;
    position: relative;
    z-index: 1;
}

.success-label {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 23px;
    padding: 9px 17px;
    background: #ffffff18;
    border: 1px solid #ffffff35;
    border-radius: 30px;
    color: #bbf7d0;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.7px;
    position: relative;
    z-index: 1;
}

/* CONTENT */

.content {
    padding: 32px 38px 35px;
}

.section-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.section-title h2 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 17px;
    color: #172033;
}

.section-title span {
    font-size: 11px;
    color: #0284c7;
    background: #e0f2fe;
    padding: 7px 12px;
    border-radius: 20px;
    font-weight: 700;
}

/* PRODUCT CARD */

.product-card {
    display: flex;
    gap: 23px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px;
    align-items: center;
}

.product-image {
    width: 145px;
    height: 145px;
    flex-shrink: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info {
    flex: 1;
    min-width: 0;
}

.product-info .caption {
    color: #94a3b8;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.product-info h3 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 20px;
    color: #172033;
    margin-bottom: 9px;
    overflow-wrap: anywhere;
}

.price {
    font-size: 20px;
    font-weight: 800;
    color: #0284c7;
    margin-bottom: 10px;
}

.description {
    font-size: 13px;
    color: #64748b;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

/* DETAIL */

.details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 13px;
    margin-top: 20px;
}

.detail-item {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 15px;
}

.detail-item small {
    display: block;
    color: #94a3b8;
    font-size: 11px;
    margin-bottom: 7px;
}

.detail-item strong {
    color: #334155;
    font-size: 13px;
}

/* DATABASE NOTICE */

.database-notice {
    display: flex;
    gap: 13px;
    align-items: center;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    padding: 16px;
    border-radius: 12px;
    margin-top: 23px;
}

.database-icon {
    width: 39px;
    height: 39px;
    background: #dbeafe;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 19px;
    flex-shrink: 0;
}

.database-text strong {
    display: block;
    font-size: 12px;
    color: #1e40af;
    margin-bottom: 4px;
}

.database-text p {
    font-size: 11px;
    color: #64748b;
    line-height: 1.6;
}

/* BUTTON */

.buttons {
    display: flex;
    gap: 13px;
    margin-top: 28px;
}

.btn {
    flex: 1;
    padding: 15px 18px;
    border-radius: 11px;
    text-align: center;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    transition: 0.3s;
}

.btn-primary {
    background: #0284c7;
    color: white;
    box-shadow: 0 5px 15px #0284c730;
}

.btn-primary:hover {
    background: #0369a1;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px #0284c740;
}

.btn-secondary {
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #e2e8f0;
    transform: translateY(-3px);
}

/* FOOTER */

footer {
    text-align: center;
    padding: 25px 15px;
    color: #94a3b8;
    font-size: 12px;
}

footer strong {
    color: #64748b;
}

/* RESPONSIVE */

@media (max-width: 600px) {

    header {
        padding: 18px 6%;
    }

    .logo {
        font-size: 19px;
    }

    .header-right {
        font-size: 10px;
    }

    .container {
        margin: 30px auto;
        padding: 0 14px;
    }

    .hero {
        padding: 35px 20px;
    }

    .hero h1 {
        font-size: 22px;
    }

    .content {
        padding: 25px 18px;
    }

    .product-card {
        flex-direction: column;
        align-items: flex-start;
    }

    .product-image {
        width: 100%;
        height: 200px;
    }

    .product-info h3 {
        font-size: 18px;
    }

    .details {
        grid-template-columns: 1fr 1fr;
    }

    .buttons {
        flex-direction: column;
    }
}

@media (max-width: 350px) {
    .details {
        grid-template-columns: 1fr;
    }

    .header-right {
        display: none;
    }
}

</style>
</head>

<body>

<!-- HEADER -->

<header>

    <div class="logo">
        KEN <span>MARKETPLACE.</span>
    </div>

    <div class="header-right">
        <div class="header-dot"></div>
        Marketplace Online
    </div>

</header>


<!-- MAIN -->

<div class="container">

    <div class="success-card">

        <!-- HERO SUCCESS -->

        <div class="hero">

            <div class="check-circle">
                <span>✓</span>
            </div>

            <h1>Produk Berhasil Ditambahkan!</h1>

            <p>
                Selamat! Produk Anda telah berhasil disimpan.
                Sekarang produk tersebut sudah menjadi bagian
                dari katalog Ken Marketplace.
            </p>

            <div class="success-label">
                ✓ &nbsp; TRANSAKSI PENYIMPANAN BERHASIL
            </div>

        </div>


        <!-- CONTENT -->

        <div class="content">

            <div class="section-title">

                <h2>Ringkasan Produk</h2>

                <span>PRODUK BARU</span>

            </div>


            <!-- PRODUCT -->

            <div class="product-card">

                <div class="product-image">

                    <img src="<?php echo htmlspecialchars($lokasi); ?>"
                         alt="Gambar Produk">

                </div>

                <div class="product-info">

                    <div class="caption">
                        Nama Produk
                    </div>

                    <h3>
                        <?php echo htmlspecialchars($nama); ?>
                    </h3>

                    <div class="price">
                        Rp <?php echo number_format((float)$harga, 0, ',', '.'); ?>
                    </div>

                    <div class="description">
                        <?php
                        echo $deskripsi !== ''
                            ? nl2br(htmlspecialchars($deskripsi))
                            : 'Tidak ada deskripsi produk.';
                        ?>
                    </div>

                </div>

            </div>


            <!-- DETAILS -->

            <div class="details">

                <div class="detail-item">

                    <small>Status Produk</small>

                    <strong style="color:#16a34a;">
                        ✓ Berhasil Disimpan
                    </strong>

                </div>

                <div class="detail-item">

                    <small>Format Gambar</small>

                    <strong>
                        <?php echo strtoupper($format[$mime]); ?>
                    </strong>

                </div>

            </div>


            <!-- DATABASE INFORMATION -->

            <div class="database-notice">

                <div class="database-icon">
                    🗄️
                </div>

                <div class="database-text">

                    <strong>Database Berhasil Diperbarui</strong>

                    <p>
                        Data produk telah dimasukkan ke database
                        <b>tesujian1</b>, tabel <b>sijaujian</b>.
                        Gambar tersimpan di folder uploads.
                    </p>

                </div>

            </div>


            <!-- BUTTONS -->

            <div class="buttons">

                <a href="Index.php" class="btn btn-primary">
                    ← Kembali ke Beranda
                </a>

                <a href="Lat_Tambah.php" class="btn btn-secondary">
                    + Tambah Produk Lagi
                </a>

            </div>

        </div>

    </div>

</div>


<!-- FOOTER -->

<footer>
    © 2026 <strong>KEN MARKETPLACE.</strong>
    All Rights Reserved.
</footer>


</body>
</html>

<?php
    } else {

        echo "<h2>Produk gagal disimpan!</h2>";
        echo "<p>" . htmlspecialchars(mysqli_error($conn)) . "</p>";

        unlink($lokasi);
    }

    mysqli_stmt_close($stmt);

} else {

    echo "Silakan isi form terlebih dahulu!";

}

mysqli_close($conn);
?>
