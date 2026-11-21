<?php
session_start();
include("../admin/koneksi.php");

if (isset($_POST["submit"])) {
    $nama    = $_POST["nama"];
    $telepon = $_POST["telepon"];
    $layanan = $_POST["layanan"];
    $alamat  = $_POST["alamat"];
    $catatan = $_POST["catatan"];

    $stmt = $conn->prepare("INSERT INTO pesanan (nama, telepon, alamat, layanan, catatan, status, tanggal_pesanan, harga)
              VALUES (:nama, :telepon, :alamat, :layanan, :catatan, 'Pending', NOW(), 0)");

    try {
        $stmt->execute([
            ':nama'    => $nama,
            ':telepon' => $telepon,
            ':alamat'  => $alamat,
            ':layanan' => $layanan,
            ':catatan' => $catatan,
        ]);
        echo "<script>
                alert('Pesanan berhasil dikirim! Kami akan segera memproses pesanan Anda.');
                window.location.href='pesanan.php';
              </script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Laundry — Sparklee</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/pesanan.css">
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <a href="../index.php" class="topbar-brand">
        <div class="brand-icon"><span class="material-symbols-outlined">local_laundry_service</span></div>
        <span class="brand-name">Sparklee Laundry</span>
    </a>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Buat Pesanan Laundry</h1>
    <p>Isi formulir di bawah ini dan kami akan segera menjemput cucian Anda</p>
</div>

<!-- PILIHAN LAYANAN (visual helper) -->
<div class="services-section">
    <p class="section-title">Pilih Jenis Layanan</p>
    <div class="services-grid">
        <div class="service-pill" onclick="pickService('reguler', this)">
            <span class="material-symbols-outlined">local_laundry_service</span>
            Cuci Kering Setrika
        </div>
        <div class="service-pill" onclick="pickService('kilat', this)">
            <span class="material-symbols-outlined">bolt</span>
            Laundry Kilat 6 Jam
        </div>
        <div class="service-pill" onclick="pickService('dryclean', this)">
            <span class="material-symbols-outlined">dry_cleaning</span>
            Dry Clean
        </div>
        <div class="service-pill" onclick="pickService('sepatu', this)">
            <span class="material-symbols-outlined">hiking</span>
            Cuci Sepatu / Tas
        </div>
        <div class="service-pill" onclick="pickService('karpet', this)">
            <span class="material-symbols-outlined">home</span>
            Cuci Karpet / Bed Cover
        </div>
        <div class="service-pill" onclick="pickService('setrika', this)">
            <span class="material-symbols-outlined">iron</span>
            Setrika Saja
        </div>
    </div>
</div>

<!-- FORM CARD -->
<div class="form-card">
    <div class="card">
        <p class="card-title">Detail Pesanan</p>
        <form action="pesanan.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama lengkap Anda" required>
                </div>
                <div class="form-group">
                    <label for="telepon">Nomor WhatsApp</label>
                    <input type="text" name="telepon" id="telepon" placeholder="08xxxxxxxxxx" required>
                </div>
                <div class="form-group">
                    <label for="layanan">Layanan</label>
                    <select name="layanan" id="layanan" required>
                        <option value="">— Pilih layanan —</option>
                        <option value="reguler">Cuci Kering Setrika (Reguler)</option>
                        <option value="kilat">Laundry Kilat 6 Jam</option>
                        <option value="dryclean">Dry Clean</option>
                        <option value="sepatu">Cuci Sepatu / Tas</option>
                        <option value="karpet">Cuci Karpet / Bed Cover</option>
                        <option value="setrika">Setrika Saja</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label for="alamat">Alamat Penjemputan</label>
                    <textarea name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat lengkap untuk penjemputan" required></textarea>
                </div>
                <div class="form-group full">
                    <label for="catatan">Catatan Tambahan <span style="font-weight:400;color:#444654">(opsional)</span></label>
                    <textarea name="catatan" id="catatan" rows="3" placeholder="Instruksi khusus, bahan sensitif, dll."></textarea>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="submit" class="btn-submit">
                    <span class="material-symbols-outlined">send</span>
                    Kirim Pesanan
                </button>
                <a href="../index.php" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>
</div>

<script src="../assets/js/pesanan.js"></script>
</body>
</html>
