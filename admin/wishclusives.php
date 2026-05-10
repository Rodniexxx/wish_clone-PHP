<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 15;
$offset = ($page - 1) * $perPage;

$total = fetchOne("SELECT COUNT(*) as count FROM videos");
$totalPages = ceil($total['count'] / $perPage);

$items = fetchAll("SELECT * FROM videos ORDER BY created_at DESC LIMIT ? OFFSET ?", [$perPage, $offset]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishclusives | Wish 107.5 Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo"><a href="dashboard.php"><img src="https://cdn.prod.website-files.com/66e1987f36e4944240bc5ab8/6701637328a69477c92c2652_Wish-Logo.svg" alt="Wish 107.5"></a></div>
        <h2>Content</h2>
        <nav>
            <a href="dashboard.php"><span class="material-icons icon">dashboard</span> Dashboard</a>
            <a href="news.php"><span class="material-icons icon">article</span> News &amp; Features</a>
            <a href="wishclusives.php" class="active"><span class="material-icons icon">video_library</span> Wishclusives</a>
            <a href="shows.php"><span class="material-icons icon">schedule</span> Shows</a>
        </nav>
        <h2 style="margin-top:24px">System</h2>
        <nav>
            <a href="../index.php" target="_blank"><span class="material-icons icon">open_in_new</span> View Site</a>
            <a href="logout.php"><span class="material-icons icon">logout</span> Logout</a>
        </nav>
    </div>
    <div class="main">
        <div class="main-header">
            <h1>Wishclusives</h1>
            <a href="wishclusives-add.php" class="btn"><span class="material-icons">add</span> Add New</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>YouTube ID</th>
                    <th>Featured</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars(truncate($item['title'], 50)) ?></td>
                    <td><?= htmlspecialchars($item['artist']) ?></td>
                    <td><?= htmlspecialchars($item['youtube_id']) ?></td>
                    <td><?= $item['featured'] ? 'Yes' : 'No' ?></td>
                    <td><?= date('M j, Y', strtotime($item['created_at'])) ?></td>
                    <td><span class="status-badge <?= $item['status'] ?>"><?= $item['status'] ?></span></td>
                    <td class="table-actions">
                        <a href="wishclusives-edit.php?id=<?= $item['id'] ?>">Edit</a>
                        <a href="wishclusives-edit.php?id=<?= $item['id'] ?>&delete=1" onclick="return confirm('Delete this video?')" style="color:#f44329">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($totalPages > 1): ?>
        <div class="pagination" style="margin-top:24px;display:flex;gap:8px">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" style="padding:8px 12px;background:#1a1a1e;border-radius:4px;color:#ccc;text-decoration:none;font-size:13px"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
