<?php
require_once 'config.php';
require_once 'db.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$artist = fetchOne("SELECT * FROM artists WHERE slug = ? AND status = 'published'", [$slug]);

if (!$artist) {
    header('Location: artists.php');
    exit;
}

$pageTitle = htmlspecialchars($artist['name']);
$pageDesc = htmlspecialchars($artist['bio'] ?: $artist['name'] . ' - Artist on Wish 107.5');
include 'header.php';

$videos = fetchAll("SELECT v.* FROM videos v JOIN artist_videos av ON v.id = av.video_id WHERE av.artist_id = ? AND v.status = 'published' ORDER BY v.created_at DESC", [$artist['id']]);
?>
        <section class="artist-hero">
            <div class="container">
                <div class="artist-hero-inner">
                    <div class="artist-hero-image">
                        <?php if ($artist['image']): ?>
                        <img src="<?= htmlspecialchars($artist['image']) ?>" alt="<?= htmlspecialchars($artist['name']) ?>">
                        <?php else: ?>
                        <div class="artist-hero-placeholder">
                            <span class="material-icons" style="font-size:80px">person</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="artist-hero-info">
                        <h1><?= htmlspecialchars($artist['name']) ?></h1>
                        <?php if ($artist['genre']): ?>
                        <div class="artist-hero-genre"><?= htmlspecialchars($artist['genre']) ?></div>
                        <?php endif; ?>
                        <div class="artist-hero-social">
                            <?php if ($artist['social_facebook']): ?>
                            <a href="<?= htmlspecialchars($artist['social_facebook']) ?>" target="_blank" rel="noopener" class="artist-social-link" aria-label="Facebook">FB</a>
                            <?php endif; ?>
                            <?php if ($artist['social_instagram']): ?>
                            <a href="<?= htmlspecialchars($artist['social_instagram']) ?>" target="_blank" rel="noopener" class="artist-social-link" aria-label="Instagram">IG</a>
                            <?php endif; ?>
                            <?php if ($artist['social_twitter']): ?>
                            <a href="<?= htmlspecialchars($artist['social_twitter']) ?>" target="_blank" rel="noopener" class="artist-social-link" aria-label="Twitter / X">X</a>
                            <?php endif; ?>
                            <?php if ($artist['social_spotify']): ?>
                            <a href="<?= htmlspecialchars($artist['social_spotify']) ?>" target="_blank" rel="noopener" class="artist-social-link" aria-label="Spotify">SP</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php if ($artist['bio']): ?>
        <section class="content-section">
            <div class="container">
                <div class="artist-bio">
                    <h2 class="section-title">About</h2>
                    <p><?= nl2br(htmlspecialchars($artist['bio'])) ?></p>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($videos)): ?>
        <section class="content-section" style="padding-top:0">
            <div class="container">
                <h2 class="section-title">Wishclusives</h2>
                <p class="section-subtitle">Performances by <?= htmlspecialchars($artist['name']) ?> on Wish 107.5 Bus</p>
                <div class="video-grid-large">
                    <?php foreach ($videos as $video): ?>
                    <a href="wishclusive-single.php?slug=<?= htmlspecialchars($video['slug']) ?>" class="video-card-large">
                        <div class="thumbnail">
                            <?php if ($video['thumbnail']): ?>
                            <img src="<?= htmlspecialchars($video['thumbnail']) ?>" alt="<?= htmlspecialchars($video['title']) ?>" style="width:100%;height:100%;object-fit:cover;position:absolute">
                            <?php endif; ?>
                            <span class="material-icons play-icon">play_circle</span>
                        </div>
                        <div class="info">
                            <div class="date"><?= date('M j, Y', strtotime($video['created_at'])) ?></div>
                            <div class="title"><?= htmlspecialchars($video['artist']) ?> performs "<?= htmlspecialchars($video['title']) ?>" live on Wish 107.5 Bus</div>
                            <div class="artist"><?= htmlspecialchars($video['artist']) ?></div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php else: ?>
        <section class="content-section" style="padding-top:0">
            <div class="container">
                <div style="text-align:center;padding:40px 0;color:var(--text-muted)">
                    <p>No wishclusives linked yet.</p>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <section class="content-section" style="padding-top:0">
            <div class="container">
                <a href="artists.php" class="video-single-back">&larr; Back to Artists</a>
            </div>
        </section>
<?php include 'footer.php'; ?>
