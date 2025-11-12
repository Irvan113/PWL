<?php

$id_event = null; 


if (isset($_GET['id_event'])) {
    
   
    $id_event = intval($_GET['id_event']);
    
} else {
    
    die(" ERROR: ID Event tidak ditemukan di URL. Form tidak dapat ditampilkan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pembelian Tiket</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; 
        }
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover { background-color: #0056b3; }
        .id-display { text-align: center; margin-bottom: 15px; padding: 10px; background-color: #e9ecef; border-radius: 5px; font-size: 14px; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎟️ Form Pembelian Tiket</h2>

        <div class="id-display">
            ID Event yang akan dibeli: <strong><?php echo htmlspecialchars($id_event); ?></strong>
        </div>

        <form action="proses.php" method="post">
            
            <input type="hidden" name="id_event" value="<?= htmlspecialchars($id_event); ?>">
            
            <label for="nama_pembeli">Nama Pembeli:</label>
            <input type="text" id="nama_pembeli" name="Nama_Pembeli" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="total_tiket">Jumlah Tiket:</label>
            <input type="number" id="total_tiket" name="total_tiket" min="1" value="1" required>
            
            <button type="submit">Kirim Pembelian</button>
        </form>
    </div>
</body>
</html>