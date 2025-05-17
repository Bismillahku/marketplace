<?php
$db = new SQLite3('komentar.db');
$db->exec("CREATE TABLE IF NOT EXISTS komentar (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama TEXT,
    komentar TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $komentar = htmlspecialchars($_POST['komentar']);
    $stmt = $db->prepare("INSERT INTO komentar (nama, komentar) VALUES (:nama, :komentar)");
    $stmt->bindValue(':nama', $nama);
    $stmt->bindValue(':komentar', $komentar);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Komentar Replit PHP</title>
</head>
<body>
    <h2>Form Komentar</h2>
    <form method="post">
        Nama: <input type="text" name="nama" required><br><br>
        Komentar: <textarea name="komentar" required></textarea><br><br>
        <button type="submit">Kirim</button>
    </form>

    <h3>Komentar:</h3>
    <?php
    $results = $db->query("SELECT * FROM komentar ORDER BY id DESC");
    while ($row = $results->fetchArray()) {
        echo "<p><strong>{$row['nama']}:</strong> {$row['komentar']} <br><small>{$row['created_at']}</small></p><hr>";
    }
    ?>
</body>
</html>
