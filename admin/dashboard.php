<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Wish 107.5 Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #121113;
            color: #fff;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: #1a1a1e;
            border-right: 1px solid rgba(255,255,255,0.05);
            padding: 24px 0;
        }
        .sidebar .logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 16px;
        }
        .sidebar .logo img { width: 40px; }
        .sidebar h2 {
            font-size: 14px;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 24px;
            margin-bottom: 8px;
        }
        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: #ccc;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }
        .sidebar nav a:hover, .sidebar nav a.active {
            background: rgba(244,67,41,0.1);
            color: #f44329;
        }
        .sidebar nav a .icon { font-size: 20px; }
        .main {
            margin-left: 240px;
            padding: 32px;
        }
        .main-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }
        .main-header h1 { font-size: 28px; font-weight: 800; }
        .main-header .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 14px;
            color: #888;
        }
        .main-header .user-info a {
            color: #f44329;
            text-decoration: none;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }
        .stats-5 {
            grid-template-columns: repeat(5, 1fr);
        }
        .stat-card {
            background: #1a1a1e;
            border-radius: 8px;
            padding: 24px;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: 800;
            color: #f44329;
        }
        .stat-card .label {
            color: #888;
            font-size: 14px;
            margin-top: 4px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #f44329;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
        }
        .btn:hover { background: #b4301e; }
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
        }
        .btn-secondary {
            background: #2a2a2e;
        }
        .btn-secondary:hover { background: #444; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #1a1a1e;
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            text-align: left;
            padding: 16px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        td {
            padding: 16px;
            font-size: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        tr:last-child td { border-bottom: none; }
        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .table-actions {
            display: flex;
            gap: 8px;
        }
        .table-actions a {
            color: #888;
            text-decoration: none;
            font-size: 13px;
        }
        .table-actions a:hover { color: #f44329; }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-badge.published { background: rgba(76,175,80,0.2); color: #4caf50; }
        .status-badge.draft { background: rgba(255,152,0,0.2); color: #ff9800; }
        .status-badge.pending { background: rgba(255,152,0,0.2); color: #ff9800; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <a href="dashboard.php"><img src="https://cdn.prod.website-files.com/66e1987f36e4944240bc5ab8/6701637328a69477c92c2652_Wish-Logo.svg" alt="Wish 107.5"></a>
        </div>
        <h2>Content</h2>
        <nav>
            <a href="dashboard.php" class="active"><span class="material-icons icon">dashboard</span> Dashboard</a>
            <a href="news.php"><span class="material-icons icon">article</span> News &amp; Features</a>
            <a href="wishclusives.php"><span class="material-icons icon">video_library</span> Wishclusives</a>
            <a href="shows.php"><span class="material-icons icon">schedule</span> Shows</a>
            <a href="artists.php"><span class="material-icons icon">people</span> Artists</a>
            <a href="wishes.php"><span class="material-icons icon">favorite</span> Wishes</a>
        </nav>
        <h2 style="margin-top:24px">System</h2>
        <nav>
            <a href="../index.php" target="_blank"><span class="material-icons icon">open_in_new</span> View Site</a>
            <a href="logout.php"><span class="material-icons icon">logout</span> Logout</a>
        </nav>
    </div>
    <div class="main">
        <div class="main-header">
            <h1>Dashboard</h1>
            <div class="user-info">
                Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <?php
        $newsCount = fetchOne("SELECT COUNT(*) as count FROM news")['count'];
        $videoCount = fetchOne("SELECT COUNT(*) as count FROM videos")['count'];
        $showsCount = fetchOne("SELECT COUNT(*) as count FROM shows")['count'];
        $artistCount = fetchOne("SELECT COUNT(*) as count FROM artists")['count'];
        $wishCount = fetchOne("SELECT COUNT(*) as count FROM wishes WHERE status = 'pending'")['count'];
        ?>
        <div class="stats stats-5">
            <div class="stat-card">
                <div class="number"><?= $newsCount ?></div>
                <div class="label">News &amp; Features</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= $videoCount ?></div>
                <div class="label">Wishclusives</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= $showsCount ?></div>
                <div class="label">Shows</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= $artistCount ?></div>
                <div class="label">Artists</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= $wishCount ?></div>
                <div class="label">Pending Wishes</div>
            </div>
        </div>
        <div class="section-title">Recent News</div>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $recentNews = fetchAll("SELECT n.*, c.name as category_name FROM news n LEFT JOIN categories c ON n.category_id = c.id ORDER BY n.created_at DESC LIMIT 5"); ?>
                <?php foreach ($recentNews as $item): ?>
                <tr>
                    <td><?= htmlspecialchars(truncate($item['title'], 50)) ?></td>
                    <td><?= htmlspecialchars($item['category_name'] ?? '-') ?></td>
                    <td><?= date('M j, Y', strtotime($item['created_at'])) ?></td>
                    <td><span class="status-badge <?= $item['status'] ?>"><?= $item['status'] ?></span></td>
                    <td class="table-actions"><a href="news-edit.php?id=<?= $item['id'] ?>">Edit</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
