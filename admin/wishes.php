<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 15;
$offset = ($page - 1) * $perPage;

if ($statusFilter && in_array($statusFilter, ['pending', 'approved', 'rejected'])) {
    $total = fetchOne("SELECT COUNT(*) as count FROM wishes WHERE status = ?", [$statusFilter]);
    $items = fetchAll("SELECT * FROM wishes WHERE status = ? ORDER BY created_at DESC LIMIT ? OFFSET ?", [$statusFilter, $perPage, $offset]);
} else {
    $statusFilter = '';
    $total = fetchOne("SELECT COUNT(*) as count FROM wishes");
    $items = fetchAll("SELECT * FROM wishes ORDER BY created_at DESC LIMIT ? OFFSET ?", [$perPage, $offset]);
}
$totalPages = ceil($total['count'] / $perPage);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishes | Wish 107.5 Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="admin-style.css">
    <style>
        .filter-bar { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
        .filter-bar a { padding:8px 16px; border-radius:4px; font-size:13px; text-decoration:none; color:#ccc; background:#2a2a2e; }
        .filter-bar a.active { background:#f44329; color:#fff; }
        .status-badge.pending { background:rgba(255,152,0,0.2); color:#ff9800; }
        .status-badge.rejected { background:rgba(244,67,54,0.2); color:#f44336; }
        .wish-message { max-width:300px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color:#aaa; font-size:13px; }
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
            <h1>Wishes &amp; Song Requests</h1>
        </div>
        <div class="filter-bar">
            <a href="wishes.php" class="<?= !$statusFilter ? 'active' : '' ?>">All</a>
            <a href="wishes.php?status=pending" class="<?= $statusFilter == 'pending' ? 'active' : '' ?>">Pending</a>
            <a href="wishes.php?status=approved" class="<?= $statusFilter == 'approved' ? 'active' : '' ?>">Approved</a>
            <a href="wishes.php?status=rejected" class="<?= $statusFilter == 'rejected' ? 'active' : '' ?>">Rejected</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['wish_type'] == 'song' ? 'Song Request' : 'Personal Wish' ?></td>
                    <td><div class="wish-message"><?= htmlspecialchars($item['message']) ?></div></td>
                    <td><?= date('M j, Y', strtotime($item['created_at'])) ?></td>
                    <td><span class="status-badge <?= $item['status'] ?>"><?= $item['status'] ?></span></td>
                    <td class="table-actions">
                        <a href="wishes-edit.php?id=<?= $item['id'] ?>">View / Edit</a>
                        <a href="wishes-edit.php?id=<?= $item['id'] ?>&delete=1" onclick="return confirm('Delete this wish?')" style="color:#f44329">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                <tr><td colspan="6" style="text-align:center;color:#888">No wishes found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if ($totalPages > 1): ?>
        <div class="pagination" style="margin-top:24px;display:flex;gap:8px">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?<?= $statusFilter ? "status=$statusFilter&" : '' ?>page=<?= $i ?>" style="padding:8px 12px;background:#1a1a1e;border-radius:4px;color:#ccc;text-decoration:none;font-size:13px"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
