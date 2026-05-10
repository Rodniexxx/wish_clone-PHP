<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? slugify($title));
    $day_of_week = $_POST['day_of_week'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $dj_name = trim($_POST['dj_name'] ?? '');
    $status = $_POST['status'] ?? 'published';
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('show_') . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $filename);
        $image = 'uploads/' . $filename;
    }

    $existing = fetchOne("SELECT id FROM shows WHERE slug = ?", [$slug]);
    $slug = $existing ? $slug . '-' . uniqid() : $slug;

    insert("INSERT INTO shows (title, slug, day_of_week, start_time, end_time, description, dj_name, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
        [$title, $slug, $day_of_week, $start_time, $end_time, $description, $dj_name, $image, $status]);

    header('Location: shows.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Show | Wish 107.5 Admin</title>
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
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px;
            background: #f44329; color: #fff; border: none; border-radius: 4px;
            font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; }
        .btn:hover { background: #b4301e; }
        .btn-secondary { background: #2a2a2e; }
        .btn-secondary:hover { background: #444; }
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
            <a href="shows.php" class="active"><span class="material-icons icon">schedule</span> Shows</a>
        </nav>
        <h2 style="margin-top:24px">System</h2>
        <nav>
            <a href="../index.php" target="_blank"><span class="material-icons icon">open_in_new</span> View Site</a>
            <a href="logout.php"><span class="material-icons icon">logout</span> Logout</a>
        </nav>
    </div>
    <div class="main">
        <div class="main-header">
            <h1>Add Show</h1>
            <a href="shows.php" class="btn btn-secondary"><span class="material-icons">arrow_back</span> Back</a>
        </div>
        <form method="POST" enctype="multipart/form-data" class="form-card">
            <div class="form-group">
                <label for="title">Show Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="dj_name">DJ Name</label>
                <input type="text" id="dj_name" name="dj_name">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="day_of_week">Day of Week</label>
                    <select id="day_of_week" name="day_of_week" required>
                        <option value="">Select day</option>
                        <option value="Mon-Fri">Monday - Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                        <option value="Daily">Daily</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="text" id="start_time" name="start_time" placeholder="e.g. 5:00 AM" required>
                </div>
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="text" id="end_time" name="end_time" placeholder="e.g. 9:00 AM" required>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image (optional)</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div style="display:flex;gap:12px">
                <button type="submit" class="btn"><span class="material-icons">save</span> Save</button>
                <a href="shows.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
