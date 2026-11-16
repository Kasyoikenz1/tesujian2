
<?php
include "Lat_Connect.php";

$sql = "SELECT * FROM sijaujian";
$hasil = mysqli_query($conn, $sql);

if (!$hasil) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tambah Produk - Ken Marketplace</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            background: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }

        /* HEADER */
        header {
            background: #0f172a;
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        .logo {
            color: white;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .logo span {
            color: #38bdf8;
        }

        .header-info {
            color: #cbd5e1;
            font-size: 13px;
        }

        /* CONTAINER */
        .container {
            max-width: 1100px;
            margin: 55px auto;
            padding: 0 25px;
        }

        .judul {
            margin-bottom: 30px;
        }

        .judul h2 {
            font-size: 30px;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .judul p {
            color: #64748b;
            font-size: 15px;
        }

        /* FORM LAYOUT */
        .form-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 25px;
            align-items: stretch;
        }

        /* INFO CARD */
        .info-box {
            background: linear-gradient(145deg, #0f172a, #164e8a);
            color: white;
            border-radius: 18px;
            padding: 35px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 500px;
        }

        .info-icon {
            font-size: 55px;
            margin-bottom: 25px;
        }

        .info-box h3 {
            font-size: 25px;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .info-box p {
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.8;
        }

        .info-list {
            margin-top: 30px;
        }

        .info-list div {
            margin-bottom: 17px;
            font-size: 14px;
            color: #e2e8f0;
        }

        .info-list span {
            color: #38bdf8;
            margin-right: 10px;
        }

        .info-footer {
            border-top: 1px solid #ffffff30;
            padding-top: 20px;
            color: #cbd5e1;
            font-size: 12px;
        }

        /* FORM BOX */
        .form-box {
            background: white;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(15,23,42,0.06);
        }

        .form-title {
            margin-bottom: 28px;
        }

        .form-title h3 {
            color: #0f172a;
            font-size: 21px;
            margin-bottom: 7px;
        }

        .form-title p {
            color: #94a3b8;
            font-size: 13px;
        }

        /* INPUT */
        .form-group {
            margin-bottom: 21px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            font-weight: 600;
            font-size: 14px;
            color: #334155;
        }

        input, textarea {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #f8fafc;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: 0.3s;
        }

        input:focus, textarea:focus {
            border-color: #0284c7;
            background: white;
            box-shadow: 0 0 0 3px #0284c720;
        }

        input::placeholder, textarea::placeholder {
            color: #94a3b8;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        input[type="file"] {
            background: #f8fafc;
            cursor: pointer;
        }

        input[type="file"]::file-selector-button {
            background: #e0f2fe;
            color: #0369a1;
            border: none;
            padding: 9px 13px;
            border-radius: 6px;
            margin-right: 12px;
            cursor: pointer;
            font-weight: 600;
        }

        .petunjuk {
            color: #94a3b8;
            font-size: 12px;
            margin-top: 8px;
        }

        /* BUTTON */
        .tombol {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        button, .kembali {
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: 0.3s;
        }

        button {
            flex: 1;
            background: #0284c7;
            color: white;
        }

        button:hover {
            background: #0369a1;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px #0284c740;
        }

        .kembali {
            background: #e2e8f0;
            color: #334155;
        }

        .kembali:hover {
            background: #cbd5e1;
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 25px;
            color: #94a3b8;
            font-size: 13px;
        }

        /* RESPONSIVE */
        @media (max-width: 750px) {

            header {
                padding: 18px 6%;
            }

            .header-info {
                display: none;
            }

            .container {
                margin: 35px auto;
            }

            .form-wrapper {
                grid-template-columns: 1fr;
            }

            .info-box {
                min-height: auto;
                padding: 25px;
            }

            .info-footer {
                margin-top: 25px;
            }

            .form-box {
                padding: 25px;
            }

            .judul h2 {
                font-size: 25px;
            }
        }

        @media (max-width: 400px) {

            .tombol {
                flex-direction: column;
            }

            .logo {
                font-size: 20px;
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

        <div class="header-info">
            Platform Penjualan Produk Digital & Elektronik
        </div>

    </header>


    <!-- MAIN CONTENT -->
    <div class="container">

        <div class="judul">
            <h2>Tambah Produk</h2>

            <p>
                Kelola dan tambahkan produk baru ke dalam
                katalog Ken Marketplace.
            </p>
        </div>


        <div class="form-wrapper">

            <!-- INFORMATION -->
            <div class="info-box">

                <div>

                    <div class="info-icon">
                        🛍️
                    </div>

                    <h3>
                        Mulai Jual Produk Anda!
                    </h3>

                    <p>
                        Tambahkan produk terbaik Anda ke
                        Ken Marketplace. Lengkapi informasi
                        produk agar pelanggan dapat
                        mengenal produk Anda.
                    </p>

                    <div class="info-list">

                        <div>
                            <span>✓</span>
                            Nama produk yang jelas
                        </div>

                        <div>
                            <span>✓</span>
                            Harga produk yang sesuai
                        </div>

                        <div>
                            <span>✓</span>
                            Deskripsi produk menarik
                        </div>

                        <div>
                            <span>✓</span>
                            Foto produk berkualitas
                        </div>

                    </div>

                </div>

                <div class="info-footer">
                    KEN MARKETPLACE
                    <br>
                    Your Trusted Online Marketplace.
                </div>

            </div>


            <!-- FORM -->
            <div class="form-box">

                <div class="form-title">

                    <h3>Informasi Produk</h3>

                    <p>
                        Isi seluruh informasi produk di bawah ini.
                    </p>

                </div>


                <form action="Lat_Insert.php" method="POST"
                      enctype="multipart/form-data">

                    <div class="form-group">

                        <label>Nama Produk</label>

                        <input type="text" name="Nama"
                               placeholder="Contoh: Laptop ASUS"
                               required>

                    </div>


                    <div class="form-group">

                        <label>Harga Produk (Rp)</label>

                        <input type="number" name="Harga"
                               placeholder="Contoh: 5000000"
                               min="1" required>

                    </div>


                    <div class="form-group">

                        <label>Deskripsi Produk</label>

                        <textarea name="Deskripsi" rows="5"
                                  placeholder="Jelaskan spesifikasi dan keunggulan produk..."></textarea>

                    </div>


                    <div class="form-group">

                        <label>Gambar Produk</label>

                        <input type="file" name="Gambar"
                               accept=".jpg,.jpeg,.png"
                               required>

                        <p class="petunjuk">
                            Format JPG, JPEG, atau PNG.
                            Maksimal ukuran 2 MB.
                        </p>

                    </div>


                    <div class="tombol">

                        <button type="submit">
                            + Simpan Produk
                        </button>

                        <a href="Index.php" class="kembali">
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- FOOTER -->
    <footer>
        © 2026 KEN MARKETPLACE. All Rights Reserved.
    </footer>

</body>
</html>
