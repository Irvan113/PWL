<?php
// BAGIAN PHP UNTUK MENYIMPAN DATA
// Anda bisa mengubah isi dari variabel di bawah ini
$nama_lengkap = "Teuku Irvan";
$bidang_keahlian = "Desain Grafis, Web Development";
$hobi = "Membaca buku, bermain game";
$lain_lain = "Tertarik dengan teknologi terbaru.";

$nim = "24.62.0219";
$kelas = "BCIS";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <style>
        /* Reset CSS dasar */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Style untuk Header */
        .header {
            background-color: #000;
            color: #fff;
            padding: 30px 20px;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
        }

        /* Container utama untuk sidebar dan konten */
        .main-container {
            display: flex;
            flex: 1; /* Membuat container ini mengisi sisa ruang vertikal */
        }

        /* Style untuk Sidebar */
        .sidebar {
            width: 20%;
            background-color: #e0e0e0;
            padding: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #007bff;
            font-size: 1.1em;
        }

        /* Style untuk Konten Utama */
        .content {
            width: 80%;
            padding: 20px;
            background-color: #fff;
        }

        .content h2 {
            margin-top: 0;
        }

        /* Style untuk Footer */
        .footer {
            background-color: #555;
            color: #fff;
            text-align: center;
            padding: 15px 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        HEADER
    </div>

    <div class="main-container">
        <div class="sidebar">
            <ul>
                <li><a href="#">Link1</a></li>
                <li><a href="#">Link2</a></li>
                <li><a href="#">Link3</a></li>
                <li><a href="#">Link4</a></li>
            </ul>
        </div>

        <div class="content">
            <h2>About Me</h2>
            <p><strong>Nama :</strong> <?php echo $nama_lengkap; ?></p>
            <p><strong>Bidang Keahlian :</strong> <?php echo $bidang_keahlian; ?></p>
            <p><strong>Hobi :</strong> <?php echo $hobi; ?></p>
            <p><strong>dll :</strong> <?php echo $lain_lain; ?></p>
        </div>
    </div>

    <div class="footer">
        Nama : <?php echo $nama_lengkap; ?> | NIM : <?php echo $nim; ?> | Kelas : <?php echo $kelas; ?>
    </div>

</body>
</html>