<?php
session_start();
include("koneksi.php");

// Proteksi keamanan — hanya admin yang login yang bisa menghapus
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("location: login.php");
    exit();
}

// Validasi id: harus ada dan berupa angka
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = (int) $_GET["id"];

    $stmt = $conn->prepare("DELETE FROM pesanan WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("location: dashboard.php");
exit();
?>
