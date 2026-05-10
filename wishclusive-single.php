<?php
require_once 'config.php';
require_once 'db.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$video = fetchOne("SELECT * FROM videos WHERE slug = ? AND status = 'published'", [$slug]);

if (!$video) {
    header('Location: wishclusives.php');
    exit;
}

$artist = fetchOne("SELECT * FROM artists WHERE name = ? AND status = 'published'", [$video['artist']]);

$pageTitle = htmlspecialchars($video['artist']) . ' performs "' . htmlspecialchars($video['title']) . '" live on Wish 107.5 Bus';
$pageDesc = htmlspecialchars($video['description'] ?: $pageTitle);
include 'header.php';
?>
        <section class="video-single">
            <div class="container">
                <div class="video-single-player">
                    <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($video['youtube_id']) ?>?autoplay=1&rel=0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
                <div class="video-single-body">
                    <div class="video-single-label">Wishclusive</div>
                    <h1><?= htmlspecialchars($video['artist']) ?> performs &ldquo;<?= htmlspecialchars($video['title']) ?>&rdquo; live on Wish 107.5 Bus</h1>
                    <div class="video-single-meta">
                        <span>Performed by <strong><?php if ($artist): ?><a href="artist-single.php?slug=<?= htmlspecialchars($artist['slug']) ?>" style="color:var(--brand)"><?= htmlspecialchars($video['artist']) ?></a><?php else: ?><?= htmlspecialchars($video['artist']) ?><?php endif; ?></strong></span>
                        <span class="sep">|</span>
                        <span><?= date('F j, Y', strtotime($video['created_at'])) ?></span>
                    </div>
                    <div class="video-single-details">
                        <div class="detail-item">
                            <span class="detail-label">Song Title</span>
                            <span class="detail-value"><?= htmlspecialchars($video['title']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Artist</span>
                            <span class="detail-value"><?php if ($artist): ?><a href="artist-single.php?slug=<?= htmlspecialchars($artist['slug']) ?>" style="color:var(--brand)"><?= htmlspecialchars($video['artist']) ?></a><?php else: ?><?= htmlspecialchars($video['artist']) ?><?php endif; ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Date uploaded</span>
                            <span class="detail-value"><?= date('F j, Y', strtotime($video['created_at'])) ?></span>
                        </div>
                    </div>
                    <?php if ($video['description']): ?>
                    <p class="video-single-desc"><?= htmlspecialchars($video['description']) ?></p>
                    <?php endif; ?>
                    <a href="wishclusives.php" class="video-single-back">&larr; Back to Wishclusives</a>
                </div>
            </div>
        </section>
<?php include 'footer.php'; ?>
