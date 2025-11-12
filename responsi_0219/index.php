<?php
$db_name = "responsi_0219"; 
$conn = mysqli_connect("localhost", "root", "", $db_name);

if (!$conn) {
    die(' Gagal terhubung ke MySQLi: ' . mysqli_connect_error());
}

// Query Data
$sql = "SELECT id_event, nama_event, harga_event, kuota_event FROM events";
$query = mysqli_query($conn, $sql);

if ($query === false) {
    die(" Error pada query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event Tersedia</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .event-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        .event-card h3 { color: #333; margin-top: 0; }
        .event-card .info { margin-bottom: 10px; }
        .event-card .kuota-habis { color: red; font-weight: bold; }
        .buy-link { background-color: #007bff; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .buy-link:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>🎟️ Daftar Event yang Tersedia</h1>
    
    <?php
    if (mysqli_num_rows($query) > 0) {
        
        while ($row = mysqli_fetch_assoc($query)) {
            $id = $row['id_event'];
            $nama = $row['nama_event'];
            $harga = number_format($row['harga_event'], 0, ',', '.'); 
            $kuota = $row['kuota_event'];
            $is_available = $kuota > 0;
            ?>
            
            <div class="event-card">
                <h3><?php echo htmlspecialchars($nama); ?></h3>
                <div class="info">
                    <strong>💰 Harga Tiket:</strong> Rp<?php echo $harga; ?>
                </div>
                <div class="info">
                    <strong>📝 Sisa Kuota:</strong> 
                    <?php if ($is_available): ?>
                        <?php echo $kuota; ?>
                    <?php else: ?>
                        <span class="kuota-habis">HABIS</span>
                    <?php endif; ?>
                </div>
                
                <?php if ($is_available): ?>
                    <a href="beli.php?id_event=<?php echo $id; ?>" class="buy-link">Beli Tiket</a>
                <?php endif; ?>
            </div>
            
            <?php
        }
    
    } else {
    ?>
        <h2>Tiket yang anda cari tidak tersedia, silahkan ganti opsi lainnya</h2>
    <?php
    }
    ?>

</body>
</html>

<?php
mysqli_close($conn);
?>