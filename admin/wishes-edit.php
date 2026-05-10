<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);

if (isset($_GET['delete'])) {
    execute("DELETE FROM wishes WHERE id = ?", [$id]);
    header('Location: wishes.php');
    exit;
}

$item = fetchOne("SELECT * FROM wishes WHERE id = ?", [$id]);
if (!$item) { header('Location: wishes.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? 'pending';
    $approved_at = $status == 'approved' ? date('Y-m-d H:i:s') : null;
    execute("UPDATE wishes SET status = ?, approved_at = ? WHERE id = ?", [$status, $approved_at, $id]);
    header('Location: wishes.php');
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wish | Wish 107.5 Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="admin-style.css">
    <style>
        .form-card { background: #1a1a1e; border-radius: 8px; padding: 32px; max-width: 600px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 6px; color: #ccc; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px 16px; background: #2a2a2e; border: 1px solid #444;
            border-radius: 4px; color: #fff; font-size: 14px; font-family: inherit;
        }
        .form-group textarea { min-height: 120px; resize: vertical; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: #f44329;
        }
        .detail-row { display:flex; padding:12px 0; border-bottom:1px solid rgba(255,255,255,0.05); }
        .detail-label { width:140px; color:#888; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:1px; }
        .detail-value { flex:1; color:#fff; font-size:15px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><a href="dashboard.php"><img src="https://cdn.prod.website-files.com/66e1987f36e4944240bc5ab8/6701637328a69477c92c2652_Wish-Logo.svg" alt="Wish 107.5"></a></div>
        <h2>Content</h2>
        <nav>
            <a href="dashboard.php"><span class="material-icons icon">dashboard</span> Dashboard</a>
            <a href="news.php"><span class="material-icons icon">article</span> News &amp; Features</a>
            <a href="wishclusives.php"><span class="material-icons icon">video_library</span> Wishclusives</a>
            <a href="shows.php"><span class="material-icons icon">schedule</span> Shows</a>
            <a href="artists.php"><span class="material-icons icon">people</span> Artists</a>
            <a href="wishes.php" class="active"><span class="material-icons icon">favorite</span> Wishes</a>
        </nav>
        <h2 style="margin-top:24px">System</h2>
        <nav>
            <a href="../index.php" target="_blank"><span class="material-icons icon">open_in_new</span> View Site</a>
            <a href="logout.php"><span class="material-icons icon">logout</span> Logout</a>
        </nav>
    </div>
    <div class="main">
        <div class="main-header">
            <h1>Wish Detail</h1>
            <a href="wishes.php" class="btn btn-secondary"><span class="material-icons">arrow_back</span> Back</a>
        </div>
        <div class="form-card" style="margin-bottom:24px">
            <div class="detail-row">
                <span class="detail-label">Name</span>
                <span class="detail-value"><?= htmlspecialchars($item['name']) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value"><?= htmlspecialchars($item['email'] ?: '-') ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Type</span>
                <span class="detail-value"><?= $item['wish_type'] == 'song' ? 'Song Request' : 'Personal Wish' ?></span>
            </div>
            <?php if ($item['wish_type'] == 'song'): ?>
            <div class="detail-row">
                <span class="detail-label">Song Title</span>
                <span class="detail-value"><?= htmlspecialchars($item['song_title'] ?: '-') ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Artist</span>
                <span class="detail-value"><?= htmlspecialchars($item['song_artist'] ?: '-') ?></span>
            </div>
            <?php endif; ?>
            <div class="detail-row">
                <span class="detail-label">Message</span>
                <span class="detail-value"><?= nl2br(htmlspecialchars($item['message'])) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Submitted</span>
                <span class="detail-value"><?= date('F j, Y g:i A', strtotime($item['created_at'])) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value"><?= $item['status'] ?></span>
            </div>
        </div>
        <form method="POST" class="form-card">
            <div class="form-group">
                <label for="status">Change Status</label>
                <select id="status" name="status">
                    <option value="pending" <?= $item['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= $item['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?= $item['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>
            </div>
            <div style="display:flex;gap:12px">
                <button type="submit" class="btn"><span class="material-icons">save</span> Update Status</button>
                <a href="wishes-edit.php?id=<?= $item['id'] ?>&delete=1" class="btn" style="background:#b71c1c" onclick="return confirm('Delete this wish?')"><span class="material-icons">delete</span> Delete</a>
            </div>
        </form>
    </div>
</body>
</html>
