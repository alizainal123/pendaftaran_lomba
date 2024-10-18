<?php
// Koneksi database
function connect_db() {
    $host = 'localhost';
    $user = 'root'; 
    $pass = ''; 

    $conn = new mysqli($host, $user, $pass);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    return $conn;
}

// Membuat database dan tabel
function create_database_and_tables() {
    $conn = connect_db();
    
    // Buat database
    $sql = "CREATE DATABASE IF NOT EXISTS lomba_gambar";
    if ($conn->query($sql) === TRUE) {
        echo "Database lomba_gambar berhasil dibuat.<br>";
    } else {
        echo "Error creating database: " . $conn->error . "<br>";
    }

    // Pilih database
    $conn->select_db("lomba_gambar");

    // Buat tabel competitions
    $sql = "CREATE TABLE IF NOT EXISTS competitions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        competition_name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        date DATE NOT NULL
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Tabel competitions berhasil dibuat.<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

    // Buat tabel participants
    $sql = "CREATE TABLE IF NOT EXISTS participants (
        id INT AUTO_INCREMENT PRIMARY KEY,
        competition_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        FOREIGN KEY (competition_id) REFERENCES competitions(id) ON DELETE CASCADE
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Tabel participants berhasil dibuat.<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

    $conn->close();
}

create_database_and_tables();
?>
