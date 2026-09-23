<?php

$db = new PDO('sqlite:laptop.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Membuat tabel
$db->exec("
CREATE TABLE IF NOT EXISTS laptop (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    merek TEXT NOT NULL,
    tipe TEXT NOT NULL,
    processor TEXT NOT NULL,
    ram TEXT NOT NULL,
    penyimpanan TEXT NOT NULL,
    harga INTEGER NOT NULL,
    stok INTEGER NOT NULL
)
");

// Mengisi data awal jika tabel masih kosong
$jumlah = $db->query("SELECT COUNT(*) FROM laptop")->fetchColumn();

if ($jumlah == 0) {

    $data = [
        ['ASUS', 'Vivobook 14', 'Intel Core i5', '8 GB', 'SSD 512 GB', 7500000, 10],
        ['Lenovo', 'IdeaPad 3', 'AMD Ryzen 5', '8 GB', 'SSD 512 GB', 6800000, 8],
        ['Acer', 'Aspire 5', 'Intel Core i5', '8 GB', 'SSD 512 GB', 7200000, 6],
        ['HP', '14s', 'Intel Core i3', '8 GB', 'SSD 256 GB', 5900000, 12],
        ['MSI', 'Modern 14', 'Intel Core i5', '16 GB', 'SSD 512 GB', 9500000, 5]
    ];

    $stmt = $db->prepare("
        INSERT INTO laptop
        (merek, tipe, processor, ram, penyimpanan, harga, stok)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($data as $row) {
        $stmt->execute($row);
    }
}

$data = $db->query("SELECT * FROM laptop ORDER BY id");

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Sistem Informasi Laptop</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f2f4f7;
            margin: 0;
        }

        .header {
            background: #1e3a5f;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .container {
            width: 90%;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #ccc;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #1e3a5f;
            color: white;
            padding: 12px;
        }

        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f8f8f8;
        }

        .harga {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            color: #777;
        }

    </style>

</head>

<body>

<div class="header">

    <h1>SISTEM INFORMASI DATA LAPTOP</h1>

    <p>Informasi Produk Laptop</p>

</div>

<div class="container">

    <h2>Daftar Laptop</h2>

    <table>

        <tr>

            <th>No</th>
            <th>Merek</th>
            <th>Tipe / Model</th>
            <th>Processor</th>
            <th>RAM</th>
            <th>Penyimpanan</th>
            <th>Harga</th>
            <th>Stok</th>

        </tr>

        <?php

        $no = 1;

        while ($row = $data->fetch(PDO::FETCH_ASSOC)):

        ?>

        <tr>

            <td><?= $no++ ?></td>

            <td><?= htmlspecialchars($row['merek']) ?></td>

            <td><?= htmlspecialchars($row['tipe']) ?></td>

            <td><?= htmlspecialchars($row['processor']) ?></td>

            <td><?= htmlspecialchars($row['ram']) ?></td>

            <td><?= htmlspecialchars($row['penyimpanan']) ?></td>

            <td class="harga">
                Rp <?= number_format($row['harga'], 0, ',', '.') ?>
            </td>

            <td><?= $row['stok'] ?></td>

        </tr>

        <?php endwhile; ?>

    </table>

    <div class="footer">

        Sistem Informasi Laptop

    </div>

</div>

</body>

</html>
