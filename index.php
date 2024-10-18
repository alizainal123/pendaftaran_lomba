<?php
require 'config.php';

// Inisialisasi array untuk menyimpan kompetisi
$competitions = [];

// Query untuk mengambil data kompetisi
$sql = "SELECT * FROM competitions ORDER BY date DESC";
$result = $conn->query($sql);

// Cek hasil query
if ($result) {
    $competitions = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error fetching data: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kompetisi Lomba Gambar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Kompetisi Lomba Gambar</h2>
        <a href="add_competition.php" class="btn add-btn">Tambah Kompetisi</a>
        <?php if (!empty($competitions)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama Kompetisi</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($competitions as $competition): ?>
                        <tr>
                            <td data-label="Nama Kompetisi"><?php echo htmlspecialchars($competition['competition_name']); ?></td>
                            <td data-label="No HP"><?php echo htmlspecialchars($competition['description']); ?></td>
                            <td data-label="Tanggal"><?php echo date('d F Y', strtotime($competition['date'])); ?></td>
                            <td data-label="Aksi">
                                <a href="edit_competition.php?id=<?php echo $competition['id']; ?>" class="btn edit-btn">Edit</a>
                                <a href="delete_competition.php?id=<?php echo $competition['id']; ?>" class="btn delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus kompetisi ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada kompetisi yang tersedia.</p>
        <?php endif; ?>
    </div>
</body>
</html>
