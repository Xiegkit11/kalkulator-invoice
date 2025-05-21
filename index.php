<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Biaya</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
        .container { background: white; padding: 20px; max-width: 600px; margin: auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; }
        label { display: block; margin-top: 15px; }
        input[type="number"] { width: 100%; padding: 8px; margin-top: 5px; }
        input[type="submit"] { margin-top: 20px; width: 100%; padding: 10px; background: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        input[type="submit"]:hover { background: #0056b3; }
        .invoice { margin-top: 30px; background: #fdfdfd; padding: 20px; border-left: 5px solid #007BFF; border-radius: 5px; }
        .invoice h3 { margin-top: 0; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kalkulator Biaya</h2>
        <form method="post">
            <label for="jarak">Jarak Tempuh (km):</label>
            <input type="number" step="1" name="jarak" id="jarak" max="40" value="<?php echo isset($_POST['jarak']) ? htmlspecialchars($_POST['jarak']) : ''; ?>">

            <label>
                <input type="checkbox" name="jasa" value="1" <?php if (isset($_POST['jasa'])) echo 'checked'; ?>> Tambahkan Biaya Jasa Pelatihan (Rp180.000)
            </label>

            <label>
                <input type="checkbox" name="pasang" value="1" <?php if (isset($_POST['pasang'])) echo 'checked'; ?>> Tambahkan Biaya Pasang (Rp100.000)
            </label>

            <input type="submit" value="Hitung Biaya">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $jarak = isset($_POST["jarak"]) && $_POST["jarak"] !== '' ? floatval($_POST["jarak"]) : 0;
            if ($jarak > 40) {
                $jarak = 40;
            }

            $biaya = 0;
            $rincian = [];

            // Biaya jarak
            if ($jarak <= 0) {
             $rincian[] = "Jarak 0 km: Tidak ada biaya perjalanan.";
            } elseif ($jarak <= 5) {
             $biaya += 40000;
            $rincian[] = "Biaya perjalanan hingga 5 km: Rp40.000";
            } else {
    $tambahan = ($jarak - 5) * 3500;
    $totalJarak = 40000 + $tambahan;
    $biaya += $totalJarak;
    $rincian[] = "Biaya 5 km pertama: Rp40.000";
    $rincian[] = "Biaya tambahan " . ($jarak - 5) . " km x Rp3.500 = Rp" . number_format($tambahan, 0, ',', '.');
}


            // Tambahan biaya
            if (isset($_POST["jasa"])) {
                $biaya += 180000;
                $rincian[] = "Biaya Jasa Pelatihan: Rp180.000";
            }

            if (isset($_POST["pasang"])) {
                $biaya += 100000;
                $rincian[] = "Biaya Pasang: Rp100.000";
            }

            // Tampilkan invoice
            echo "<div class='invoice'>";
            echo "<h3>Invoice</h3>";
            echo "<ul>";
            foreach ($rincian as $item) {
                echo "<li>$item</li>";
            }
            echo "</ul>";
            echo "<strong>Total Biaya: Rp " . number_format($biaya, 0, ',', '.') . "</strong>";
            echo "</div>";
        }
        ?>
    </div>

    <script>
    document.getElementById("jarak").addEventListener("input", function () {
        if (parseFloat(this.value) > 40) {
            this.value = 40;
        }
    });
    </script>
</body>
</html>
