<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? slugify($name));
    $bio = trim($_POST['bio'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $social_facebook = trim($_POST['social_facebook'] ?? '');
    $social_instagram = trim($_POST['social_instagram'] ?? '');
    $social_twitter = trim($_POST['social_twitter'] ?? '');
    $social_spotify = trim($_POST['social_spotify'] ?? '');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $status = $_POST['status'] ?? 'published';
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('artist_') . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $filename);
        $image = 'uploads/' . $filename;
    }

    $existing = fetchOne("SELECT id FROM artists WHERE slug = ?", [$slug]);
    $slug = $existing ? $slug . '-' . uniqid() : $slug;

    insert("INSERT INTO artists (name, slug, bio, image, genre, social_facebook, social_instagram, social_twitter, social_spotify, featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
        [$name, $slug, $bio, $image, $genre, $social_facebook, $social_instagram, $social_twitter, $social_spotify, $featured, $status]);

    header('Location: artists.php');
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Artist | Wish 107.5 Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="admin-style.css">
    <style>
        .form-card { background: #1a1a1e; border-radius: 8px; padding: 32px; max-width: 700px; }
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
            <a href="artists.php" class="active"><span class="material-icons icon">people</span> Artists</a>
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
            <h1>Add Artist</h1>
            <a href="artists.php" class="btn btn-secondary"><span class="material-icons">arrow_back</span> Back</a>
        </div>
        <form method="POST" enctype="multipart/form-data" class="form-card">
            <div class="form-group">
                <label for="name">Artist Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug (leave empty to auto-generate)</label>
                <input type="text" id="slug" name="slug">
            </div>
            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" placeholder="e.g. Pop, Rock, R&B">
            </div>
            <div class="form-group">
                <label for="bio">Biography</label>
                <textarea id="bio" name="bio"></textarea>
            </div>
            <div class="form-group">
                <label for="image">Photo</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="social_facebook">Facebook URL</label>
                    <input type="url" id="social_facebook" name="social_facebook" placeholder="https://facebook.com/...">
                </div>
                <div class="form-group">
                    <label for="social_instagram">Instagram URL</label>
                    <input type="url" id="social_instagram" name="social_instagram" placeholder="https://instagram.com/...">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="social_twitter">Twitter / X URL</label>
                    <input type="url" id="social_twitter" name="social_twitter" placeholder="https://twitter.com/...">
                </div>
                <div class="form-group">
                    <label for="social_spotify">Spotify URL</label>
                    <input type="url" id="social_spotify" name="social_spotify" placeholder="https://open.spotify.com/...">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <div class="form-group checkbox-group" style="align-self:flex-end;padding-bottom:4px">
                    <input type="checkbox" id="featured" name="featured">
                    <label for="featured">Featured</label>
                </div>
            </div>
            <div style="display:flex;gap:12px">
                <button type="submit" class="btn"><span class="material-icons">save</span> Save</button>
                <a href="artists.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
