<?php
// =============================================
// KONEKSI DATABASE — Supabase PostgreSQL (PDO)
// =============================================

// Load .env file
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Abaikan komentar
        if (str_starts_with(trim($line), '#')) continue;
        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value);
            // Set sebagai environment variable
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

// Ambil kredensial dari environment
$host     = getenv('DB_HOST')     ?: 'localhost';
$port     = getenv('DB_PORT')     ?: '5432';
$dbname   = getenv('DB_NAME')     ?: 'postgres';
$username = getenv('DB_USER')     ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: '';

// Buat koneksi PDO ke PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

try {
    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
