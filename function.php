<?php
// Koneksi database
function connect_db() {
    $host = 'localhost';
    $db = 'lomba_gambar';
    $user = 'root'; 
    $pass = ''; 

    try {
        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    } catch (Exception $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Menambahkan kompetisi baru
function add_competition($name, $description, $date) {
    $conn = connect_db();
    $stmt = $conn->prepare("INSERT INTO competitions (competition_name, description, date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $description, $date);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

// Menampilkan semua kompetisi
function get_competitions() {
    $conn = connect_db();
    $result = $conn->query("SELECT * FROM competitions ORDER BY date DESC");
    $competitions = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $competitions[] = $row;
        }
    }
    $conn->close();
    return $competitions;
}

// Mengedit kompetisi
function update_competition($id, $name, $description, $date) {
    $conn = connect_db();
    $stmt = $conn->prepare("UPDATE competitions SET competition_name = ?, description = ?, date = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $description, $date, $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

// Menghapus kompetisi
function delete_competition($id) {
    $conn = connect_db();
    $stmt = $conn->prepare("DELETE FROM competitions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

// Menambahkan peserta ke kompetisi
function add_participant($competition_id, $name, $email, $phone) {
    $conn = connect_db();
    $stmt = $conn->prepare("INSERT INTO participants (competition_id, name, email, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $competition_id, $name, $email, $phone);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

// Menampilkan semua peserta untuk kompetisi tertentu
function get_participants($competition_id) {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM participants WHERE competition_id = ?");
    $stmt->bind_param("i", $competition_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $participants = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $participants[] = $row;
        }
    }
    $stmt->close();
    $conn->close();
    return $participants;
}

// Menghapus peserta
function delete_participant($id) {
    $conn = connect_db();
    $stmt = $conn->prepare("DELETE FROM participants WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}
?>
