<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan Anda telah membuat koneksi ke database sebelumnya.
    // Gantilah nilai-nilai berikut sesuai dengan pengaturan database Anda.
    $host = "mysql";
    $username = "nadineumi";
    $password = "nami1234";
    $database = "dabeee";

    // Membuat koneksi ke database
    $conn = new mysqli($host, $username, $password, $database);

    // Periksa apakah koneksi berhasil
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Tangkap data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query SQL untuk memeriksa email dan password
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email ditemukan dalam database, periksa password
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["admin_logged_in"] = true;
            header("Location: ../home.html");// Ganti dengan halaman yang sesuai
            exit;
        } else {
            $error_message = "Email atau Password kurang tepat";
            header("Location: login.php?error=" . urlencode($error_message));
            exit;
        }
    } else {
        $error_message = "Email atau Password kurang tepat";
        header("Location: login.php?error=" . urlencode($error_message));
        exit;
    }


    // Tutup koneksi database
    $conn->close() ;
}
?>