<?php

require 'config.php';


$success_message = '';
$error_message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $competition_name = trim($_POST['competition_name']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];

 
 {
    
        $stmt = $conn->prepare("INSERT INTO competitions (competition_name, description, date) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $competition_name, $description, $date);
        
            if ($stmt->execute()) {
                $success_message = "Kompetisi berhasil ditambahkan!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error_message = "Error preparing statement: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kompetisi Lomba Gambar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Kompetisi Lomba Gambar</h2>


        <?php if (!empty($success_message)): ?>
            <div class="alert success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="alert error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="competition_name">Nama Kompetisi:</label>
                <input type="text" name="competition_name" id="competition_name" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="date">Tanggal:</label>
                <input type="date" name="date" id="date" required>
            </div>
            <button type="submit" class="btn submit-btn">Tambah Kompetisi</button>
            <a href="index.php" class="btn back-btn">Kembali</a>
        </form>
    </div>
</body>
</html>
