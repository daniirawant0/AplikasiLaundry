<?php
session_start();
include("koneksi.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: login.php");
    exit();
}

// =============================================
// PROSES UPDATE STATUS (saat form di-submit)
// =============================================
if (isset($_POST['update_status'])) {
    $id     = $_POST['id'];
    $status = $_POST['status'];
    $allowed = ['Pending', 'Diproses', 'Selesai', 'Dibatalkan'];
    if (in_array($status, $allowed)) {
        $stmt = $conn->prepare("UPDATE pesanan SET status = :status WHERE id = :id");
        $stmt->execute([':status' => $status, ':id' => $id]);
    }
    header("location: dashboard.php");
    exit();
}

// =============================================
// AMBIL STATISTIK RINGKASAN
// =============================================
$total    = $conn->query("SELECT COUNT(*) as c FROM pesanan")->fetch()['c'];
$pending  = $conn->query("SELECT COUNT(*) as c FROM pesanan WHERE status='Pending'")->fetch()['c'];
$diproses = $conn->query("SELECT COUNT(*) as c FROM pesanan WHERE status='Diproses'")->fetch()['c'];
$selesai  = $conn->query("SELECT COUNT(*) as c FROM pesanan WHERE status='Selesai'")->fetch()['c'];

// =============================================
// AMBIL SEMUA DATA PESANAN
// =============================================
$query  = "SELECT id, nama, telepon, layanan, alamat, catatan, status, tanggal_pesanan FROM pesanan ORDER BY tanggal_pesanan DESC";
$result = $conn->query($query);
$rows   = $result->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Sparklee Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<!-- ══════════════ SIDEBAR ══════════════ -->
<aside>
    <div>
        <div class="brand">
            <div class="brand-icon">
                <span class="material-symbols-outlined">local_laundry_service</span>
            </div>
            <div>
                <div class="brand-name">Sparklee Laundry</div>
                <div class="brand-sub">Panel Admin</div>
            </div>
        </div>
        <nav>
            <a href="dashboard.php" class="active">
                <span class="material-symbols-outlined">orders</span>
                Daftar Pesanan
            </a>
            <a href="../index.php">
                <span class="material-symbols-outlined">home</span>
                Halaman Utama
            </a>
        </nav>
    </div>
    <div class="sidebar-footer">
        <div class="admin-card">
            <div class="avatar">AD</div>
            <div>
                <div class="admin-name">Admin</div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
        <a href="logout.php" class="btn btn-ghost" style="margin-top:10px; width:100%; justify-content:center;">
            <span class="material-symbols-outlined">logout</span>
            Logout
        </a>
    </div>
</aside>

<!-- ══════════════ MAIN ══════════════ -->
<main>
    <!-- TOP BAR -->
    <header class="topbar">
        <div class="topbar-title">
            <h1>Daftar Pesanan</h1>
            <p><?= date('l, d F Y') ?> • <?= $total ?> total pesanan</p>
        </div>
        <div class="topbar-actions">
            <a href="../Public/pesanan.php" class="btn btn-ghost">
                <span class="material-symbols-outlined">add</span>
                Pesanan Baru
            </a>
        </div>
    </header>

    <!-- CONTENT BODY -->
    <div class="content-body">

        <!-- KPI CARDS -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-header">
                    <span class="kpi-label">Total Pesanan</span>
                    <span class="kpi-icon total"><span class="material-symbols-outlined">inventory_2</span></span>
                </div>
                <div class="kpi-value"><?= $total ?></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-header">
                    <span class="kpi-label">Pending</span>
                    <span class="kpi-icon warning"><span class="material-symbols-outlined">schedule</span></span>
                </div>
                <div class="kpi-value"><?= $pending ?></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-header">
                    <span class="kpi-label">Diproses</span>
                    <span class="kpi-icon info"><span class="material-symbols-outlined">local_laundry_service</span></span>
                </div>
                <div class="kpi-value"><?= $diproses ?></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-header">
                    <span class="kpi-label">Selesai</span>
                    <span class="kpi-icon success"><span class="material-symbols-outlined">verified</span></span>
                </div>
                <div class="kpi-value"><?= $selesai ?></div>
            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="table-section">
            <div class="table-toolbar">
                <span class="table-toolbar-title">Antrian Pesanan</span>
                <div class="search-wrap">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" id="searchInput" placeholder="Cari nama, layanan..." oninput="filterTable()">
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <button class="tab-btn active" onclick="filterByStatus('all', this)">Semua (<?= $total ?>)</button>
                <button class="tab-btn" onclick="filterByStatus('Pending', this)">Pending (<?= $pending ?>)</button>
                <button class="tab-btn" onclick="filterByStatus('Diproses', this)">Diproses (<?= $diproses ?>)</button>
                <button class="tab-btn" onclick="filterByStatus('Selesai', this)">Selesai (<?= $selesai ?>)</button>
            </div>

            <!-- Table -->
            <div class="table-wrap" style="margin-top: 14px;">
                <table id="mainTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Alamat</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    if (count($rows) > 0):
                        foreach ($rows as $row):
                            $statusClass = match($row['status']) {
                                'Pending'    => 'badge-pending',
                                'Diproses'   => 'badge-diproses',
                                'Selesai'    => 'badge-selesai',
                                'Dibatalkan' => 'badge-dibatalkan',
                                default      => 'badge-pending'
                            };
                    ?>
                        <tr data-status="<?= htmlspecialchars($row['status']) ?>"
                            data-search="<?= strtolower(htmlspecialchars($row['nama'] . ' ' . $row['layanan'] . ' ' . $row['telepon'])) ?>">
                            <td><?= $no++; ?></td>
                            <td>
                                <div class="td-name"><?= htmlspecialchars($row['nama']); ?></div>
                                <div class="td-phone"><?= htmlspecialchars($row['telepon']); ?></div>
                            </td>
                            <td><?= htmlspecialchars($row['layanan']); ?></td>
                            <td style="max-width:160px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"
                                title="<?= htmlspecialchars($row['alamat']); ?>">
                                <?= htmlspecialchars($row['alamat']); ?>
                            </td>
                            <td style="max-width:140px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"
                                title="<?= htmlspecialchars($row['catatan']); ?>">
                                <?= htmlspecialchars($row['catatan']) ?: '<span style="color:var(--text-muted)">—</span>'; ?>
                            </td>
                            <td>
                                <form action="dashboard.php" method="POST" style="margin:0;">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <input type="hidden" name="update_status" value="1">
                                    <select name="status"
                                        class="select-status"
                                        data-status="<?= htmlspecialchars($row['status']); ?>"
                                        onchange="this.setAttribute('data-status', this.value); this.form.submit();">
                                        <option value="Pending"    <?= $row['status'] === 'Pending'    ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Diproses"   <?= $row['status'] === 'Diproses'   ? 'selected' : ''; ?>>Diproses</option>
                                        <option value="Selesai"    <?= $row['status'] === 'Selesai'    ? 'selected' : ''; ?>>Selesai</option>
                                        <option value="Dibatalkan" <?= $row['status'] === 'Dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                                    </select>
                                </form>
                            </td>
                            <td style="white-space:nowrap; color:var(--text-muted); font-size:12px;">
                                <?= date('d M Y, H:i', strtotime($row['tanggal_pesanan'])); ?>
                            </td>
                            <td>
                                <a class="btn-hapus"
                                   href="hapus.php?id=<?= $row['id']; ?>"
                                   onclick="return confirm('Hapus pesanan atas nama <?= htmlspecialchars($row['nama'], ENT_QUOTES); ?>?');">
                                    <span class="material-symbols-outlined">delete</span>
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php
                        endforeach;
                    else:
                    ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined">inbox</span>
                                    Belum ada data pesanan
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div><!-- end table-section -->

    </div><!-- end content-body -->
</main>

<script src="../assets/js/dashboard.js"></script>
</body>
</html>
