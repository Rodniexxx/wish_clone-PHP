<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);

if (isset($_GET['delete'])) {
    execute("DELETE FROM videos WHERE id = ?", [$id]);
    header('Location: wishclusives.php');
    exit;
}

$item = fetchOne("SELECT * FROM videos WHERE id = ?", [$id]);
if (!$item) { header('Location: wishclusives.php'); exit; }

$allArtists = fetchAll("SELECT * FROM artists WHERE status = 'published' ORDER BY name ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? slugify($title));
    $artistName = trim($_POST['artist'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $youtube_id = trim($_POST['youtube_id'] ?? '');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $status = $_POST['status'] ?? 'published';
    $thumbnail = $item['thumbnail'];

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('vid_') . '.' . $ext;
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../uploads/' . $filename);
        $thumbnail = 'uploads/' . $filename;
    }

    $existing = fetchOne("SELECT id FROM videos WHERE slug = ? AND id != ?", [$slug, $id]);
    $slug = $existing ? $slug . '-' . uniqid() : $slug;

    execute("UPDATE videos SET title=?, slug=?, artist=?, description=?, youtube_id=?, thumbnail=?, featured=?, status=? WHERE id=?",
        [$title, $slug, $artistName, $description, $youtube_id, $thumbnail, $featured, $status, $id]);

    $artistRecord = fetchOne("SELECT id FROM artists WHERE name = ?", [$artistName]);
    if ($artistRecord) {
        $linked = fetchOne("SELECT 1 FROM artist_videos WHERE artist_id = ? AND video_id = ?", [$artistRecord['id'], $id]);
        if (!$linked) {
            execute("INSERT INTO artist_videos (artist_id, video_id) VALUES (?, ?)", [$artistRecord['id'], $id]);
        }
    }

    header('Location: wishclusives.php');
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wishclusive | Wish 107.5 Admin</title>
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
        .form-group textarea { min-height: 100px; resize: vertical; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: #f44329;
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .checkbox-group { display: flex; align-items: center; gap: 8px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px;
            background: #f44329; color: #fff; border: none; border-radius: 4px;
            font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; }
        .btn:hover { background: #b4301e; }
        .btn-secondary { background: #2a2a2e; }
        .btn-secondary:hover { background: #444; }
        .preview-img { max-width: 150px; margin-top: 8px; border-radius: 4px; }
    </style>
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
            <h1>Edit Wishclusive</h1>
            <a href="wishclusives.php" class="btn btn-secondary"><span class="material-icons">arrow_back</span> Back</a>
        </div>
        <form method="POST" enctype="multipart/form-data" class="form-card">
            <div class="form-group">
                <label for="title">Song Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($item['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="artist">Artist</label>
                <select id="artist" name="artist" required>
                    <option value="">Select artist</option>
                    <?php foreach ($allArtists as $a): ?>
                    <option value="<?= htmlspecialchars($a['name']) ?>" <?= $a['name'] == $item['artist'] ? 'selected' : '' ?>><?= htmlspecialchars($a['name']) ?></option>
                    <?php endforeach; ?>
                    <?php if (!in_array($item['artist'], array_column($allArtists, 'name'))): ?>
                    <option value="<?= htmlspecialchars($item['artist']) ?>" selected><?= htmlspecialchars($item['artist']) ?> (unlinked)</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="youtube_id">YouTube Video ID</label>
                <input type="text" id="youtube_id" name="youtube_id" value="<?= htmlspecialchars($item['youtube_id']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"><?= htmlspecialchars($item['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                <?php if ($item['thumbnail']): ?>
                <img src="../<?= htmlspecialchars($item['thumbnail']) ?>" alt="" class="preview-img">
                <?php endif; ?>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="published" <?= $item['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                        <option value="draft" <?= $item['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                    </select>
                </div>
                <div class="form-group checkbox-group" style="align-self:flex-end;padding-bottom:4px">
                    <input type="checkbox" id="featured" name="featured" <?= $item['featured'] ? 'checked' : '' ?>>
                    <label for="featured">Featured</label>
                </div>
            </div>
            <div style="display:flex;gap:12px">
                <button type="submit" class="btn"><span class="material-icons">save</span> Update</button>
                <a href="wishclusives.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
