<?php

require 'config.php';


$success_message = '';
$error_message = '';
$competition = null;


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    $stmt = $conn->prepare("SELECT * FROM competitions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $competition = $result->fetch_assoc();
    } else {
        $error_message = "Kompetisi tidak ditemukan.";
    }
    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $competition_name = trim($_POST['competition_name']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];

    $stmt = $conn->prepare("UPDATE competitions SET competition_name = ?, description = ?, date = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("sssi", $competition_name, $description, $date, $id);
        

        if ($stmt->execute()) {
            $success_message = "Kompetisi berhasil diperbarui!";
       
            $competition['competition_name'] = $competition_name;
            $competition['description'] = $description;
            $competition['date'] = $date;
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error_message = "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kompetisi Lomba Gambar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Kompetisi Lomba Gambar</h2>

        <?php if ($success_message): ?>
            <div class="alert success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($competition): ?>
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?php echo $competition['id']; ?>">
                <div class="form-group">
                    <label for="competition_name">Nama Kompetisi:</label>
                    <input type="text" name="competition_name" id="competition_name" value="<?php echo htmlspecialchars($competition['competition_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi:</label>
                    <textarea name="description" id="description" required><?php echo htmlspecialchars($competition['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="date">Tanggal:</label>
                    <input type="date" name="date" id="date" value="<?php echo $competition['date']; ?>" required>
                </div>
                <button type="submit" class="btn submit-btn">Update Kompetisi</button>
                <a href="index.php" class="btn back-btn">Kembali</a>
            </form>
        <?php else: ?>
            <p>Kompetisi tidak ditemukan.</p>
            <a href="index.php" class="btn back-btn">Kembali ke Daftar</a>
        <?php endif; ?>
    </div>
</body>
</html>