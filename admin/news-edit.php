<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);

if (isset($_GET['delete'])) {
    execute("DELETE FROM news WHERE id = ?", [$id]);
    header('Location: news.php');
    exit;
}

$item = fetchOne("SELECT * FROM news WHERE id = ?", [$id]);
if (!$item) { header('Location: news.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? slugify($title));
    $content = $_POST['content'] ?? '';
    $excerpt = trim($_POST['excerpt'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);
    $featured = isset($_POST['featured']) ? 1 : 0;
    $status = $_POST['status'] ?? 'published';
    $image = $item['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('news_') . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $filename);
        $image = 'uploads/' . $filename;
    }

    $existing = fetchOne("SELECT id FROM news WHERE slug = ? AND id != ?", [$slug, $id]);
    $slug = $existing ? $slug . '-' . uniqid() : $slug;

    execute("UPDATE news SET title=?, slug=?, content=?, excerpt=?, image=?, category_id=?, featured=?, status=? WHERE id=?",
        [$title, $slug, $content, $excerpt, $image, $category_id, $featured, $status, $id]);

    header('Location: news.php');
    exit;
}

$categories = fetchAll("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News | Wish 107.5 Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="admin-style.css">
    <style>
        .form-card { background: #1a1a1e; border-radius: 8px; padding: 32px; max-width: 800px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 6px; color: #ccc; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px 16px; background: #2a2a2e; border: 1px solid #444;
            border-radius: 4px; color: #fff; font-size: 14px; font-family: inherit;
        }
        .form-group textarea { min-height: 200px; resize: vertical; }
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
            <a href="news.php" class="active"><span class="material-icons icon">article</span> News &amp; Features</a>
            <a href="wishclusives.php"><span class="material-icons icon">video_library</span> Wishclusives</a>
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
            <h1>Edit News</h1>
            <a href="news.php" class="btn btn-secondary"><span class="material-icons">arrow_back</span> Back</a>
        </div>
        <form method="POST" enctype="multipart/form-data" class="form-card">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($item['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($item['slug']) ?>">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id">
                        <option value="">Select category</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $item['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="published" <?= $item['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                        <option value="draft" <?= $item['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="excerpt">Excerpt</label>
                <textarea id="excerpt" name="excerpt" style="min-height:80px"><?= htmlspecialchars($item['excerpt']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content"><?= htmlspecialchars($item['content']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if ($item['image']): ?>
                <img src="../<?= htmlspecialchars($item['image']) ?>" alt="" class="preview-img">
                <?php endif; ?>
            </div>
            <div class="form-group checkbox-group">
                <input type="checkbox" id="featured" name="featured" <?= $item['featured'] ? 'checked' : '' ?>>
                <label for="featured">Featured</label>
            </div>
            <div style="display:flex;gap:12px">
                <button type="submit" class="btn"><span class="material-icons">save</span> Update</button>
                <a href="news.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
