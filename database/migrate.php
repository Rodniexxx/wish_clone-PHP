<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

echo "=== Wish 107.5 Migration Script ===\n";
echo "Importing artists from videos table...\n";

$videos = fetchAll("SELECT DISTINCT artist FROM videos WHERE artist IS NOT NULL AND artist != ''");

foreach ($videos as $v) {
    $name = trim($v['artist']);
    $slug = slugify($name);
    $existing = fetchOne("SELECT id FROM artists WHERE slug = ?", [$slug]);
    if (!$existing) {
        insert("INSERT INTO artists (name, slug, status) VALUES (?, ?, 'published')", [$name, $slug]);
        echo "  Imported: $name\n";
    } else {
        echo "  Skipped (exists): $name\n";
    }
}

echo "Linking artists to videos...\n";
$artists = fetchAll("SELECT id, name FROM artists");
foreach ($artists as $a) {
    $vids = fetchAll("SELECT id FROM videos WHERE artist = ?", [$a['name']]);
    foreach ($vids as $vid) {
        $linked = fetchOne("SELECT 1 FROM artist_videos WHERE artist_id = ? AND video_id = ?", [$a['id'], $vid['id']]);
        if (!$linked) {
            execute("INSERT INTO artist_videos (artist_id, video_id) VALUES (?, ?)", [$a['id'], $vid['id']]);
        }
    }
}

echo "Done! Imported " . count($videos) . " artists and linked their videos.\n";
