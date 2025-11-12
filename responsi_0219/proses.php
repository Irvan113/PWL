<?php
session_start();


$db_name = "responsi_0219"; 
$conn = mysqli_connect("localhost", "root", "", $db_name);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

$is_post = false;
$id_event = 0;
$nama = '';
$email = '';
$tiket = 0;
$status_pembelian = '';
$pesan_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_post = true;
    
    $id_event = isset($_POST['id_event']) ? intval($_POST['id_event']) : 0;
    $nama     = isset($_POST['Nama_Pembeli']) ? htmlspecialchars(trim($_POST['Nama_Pembeli'])) : '';
    $email    = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $tiket    = isset($_POST['total_tiket']) ? intval($_POST['total_tiket']) : 0;

    
    $sql_check = "SELECT kuota_event FROM events WHERE id_event = ?";
    

    if ($stmt = mysqli_prepare($conn, $sql_check)) {
        mysqli_stmt_bind_param($stmt, "i", $id_event);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $kuota_tersedia = $row['kuota_event'];

            if ($tiket <= $kuota_tersedia && $tiket > 0) {
                
                $sisa_kuota_baru = $kuota_tersedia - $tiket;
                
             
                $sql_update = "UPDATE events SET kuota_event = ? WHERE id_event = ?";
                if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
                    mysqli_stmt_bind_param($stmt_update, "ii", $sisa_kuota_baru, $id_event);
                    
                    if (mysqli_stmt_execute($stmt_update)) {
                        $status_pembelian = 'sukses';
                    } else {
                        $status_pembelian = 'gagal';
                        $pesan_error = 'Gagal menyimpan transaksi ke database.';
                    }
                    mysqli_stmt_close($stmt_update);
                } else {
                     $status_pembelian = 'gagal';
                     $pesan_error = 'Error saat menyiapkan query update.';
                }

            } else {
                $status_pembelian = 'gagal';
                if ($tiket <= 0) {
                    $pesan_error = 'Jumlah tiket yang diminta tidak valid.';
                } else {
                    $pesan_error = "Maaf, kuota tiket yang tersedia hanya **$kuota_tersedia** buah. Pembelian Anda ($tiket) tidak dapat diproses.";
                }
            }
            
        } else {
            $status_pembelian = 'gagal';
            $pesan_error = 'ID Event tidak ditemukan.';
        }
        mysqli_stmt_close($stmt);
    } else {
        $status_pembelian = 'gagal';
        $pesan_error = 'Error saat menyiapkan query cek kuota.';
    }
    
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Transaksi</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px; text-align: center; }
        .success h2 { color: #28a745; border-bottom: 2px solid #28a745; }
        .failure h2 { color: #dc3545; border-bottom: 2px solid #dc3545; }
        h2 { margin-bottom: 20px; padding-bottom: 10px; }
        .message { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .success .message { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .failure .message { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; font-weight: bold; }
        .data-list { text-align: left; margin: 20px 0; border: 1px solid #eee; border-radius: 5px; padding: 15px; }
        .data-list div { padding: 8px 0; border-bottom: 1px dashed #eee; }
        .data-list div:last-child { border-bottom: none; }
        .data-list strong { display: inline-block; width: 120px; color: #555; }
        .back-link { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s; }
        .back-link:hover { background-color: #5a6268; }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($is_post && $status_pembelian == 'sukses'): ?>
            <div class="success">
                <h2>✅ Transaksi Sukses</h2>
                <div class="message">
                    Pembelian tiket **<?= $nama; ?>** untuk event ID **<?= $id_event; ?>** berhasil diproses!
                    <br>Sisa Kuota Event saat ini: **<?= $sisa_kuota_baru; ?>**
                </div>
                
                <div class="data-list">
                    <div><strong>ID Event:</strong> <?= htmlspecialchars($id_event); ?></div>
                    <div><strong>Nama Pembeli:</strong> <?= htmlspecialchars($nama); ?></div>
                    <div><strong>Email:</strong> <?= htmlspecialchars($email); ?></div>
                    <div><strong>Jumlah Tiket:</strong> <?= htmlspecialchars($tiket); ?></div>
                </div>
            </div>
            
        <?php elseif ($is_post && $status_pembelian == 'gagal'): ?>
            <div class="failure">
                <h2>❌ Transaksi Gagal</h2>
                <div class="message">
                    <?= $pesan_error; ?>
                </div>
                <p>Silakan kembali dan periksa kembali jumlah tiket yang Anda inginkan.</p>
            </div>
            
        <?php else: ?>
            <div class="failure">
                <h2>⚠️ Akses Tidak Valid</h2>
                <div class="message">
                    Akses tidak valid. Silakan gunakan form pembelian.
                </div>
            </div>
        <?php endif; ?>
        
        <a href="index.php" class="back-link">Kembali ke Daftar Event</a>
    </div>
</body>
</html>