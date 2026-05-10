<?php
require_once 'config.php';
require_once 'db.php';
$pageTitle = 'Home';
$pageDesc = 'Wish 107.5 is one of the leading music brands in the Philippines, with the Wish Bus and the Wish Music Awards as its flagship endeavors.';
include 'header.php';

$videos = fetchAll("SELECT * FROM videos WHERE status = 'published' ORDER BY created_at DESC LIMIT 12");
$newsItems = fetchAll("SELECT n.*, c.name as category_name FROM news n LEFT JOIN categories c ON n.category_id = c.id WHERE n.status = 'published' ORDER BY n.created_at DESC LIMIT 3");
$recentWishes = fetchAll("SELECT * FROM wishes WHERE status = 'approved' ORDER BY created_at DESC LIMIT 4");
$aboutText = fetchOne("SELECT setting_value FROM settings WHERE setting_key = 'about_content'");
?>
        <section class="hero">
            <div class="container">
                <div class="hero-player">
                    <div class="album-art">
                        <span class="material-icons icon">music_note</span>
                    </div>
                    <div class="status">On Air</div>
                    <div class="song-title">Playing now...</div>
                    <div class="artist-name">Wish 107.5</div>
                    <div class="player-controls">
                        <button><span class="material-icons">skip_previous</span></button>
                        <button class="play-btn" id="playBtn"><span class="material-icons">play_arrow</span></button>
                        <button class="play-btn" id="pauseBtn" style="display:none"><span class="material-icons">pause</span></button>
                        <button><span class="material-icons">skip_next</span></button>
                    </div>
                </div>
                <h1 class="hero-title">Hop aboard for the latest Wish Bus videos and more!</h1>
                <p class="hero-subtitle">Watch your favorite artists perform songs you love — and new ones you'll soon enjoy.</p>
                <a href="wishclusives.php" class="hero-btn">See all videos</a>
            </div>
        </section>

        <section class="video-section">
                <?php
                $halfCount = ceil(count($videos) / 2);
                $leftVideos = array_slice($videos, 0, $halfCount);
                $rightVideos = array_slice($videos, $halfCount);
                ?>
                <div class="video-slider">
                    <div class="video-track-wrapper">
                        <div class="video-track video-track--left">
                            <?php for ($i = 0; $i < 2; $i++): ?>
                            <?php foreach ($leftVideos as $video): ?>
                            <a href="wishclusive-single.php?slug=<?= htmlspecialchars($video['slug']) ?>" class="video-card">

    <div class="thumbnail">

        <?php if ($video['thumbnail']): ?>
        <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
             alt="<?= htmlspecialchars($video['title']) ?>">
        <?php endif; ?>

        <span class="material-icons play-icon">play_circle</span>

        
        <div class="info">
            <div class="artist"><?= htmlspecialchars($video['artist']) ?></div>
            <div class="title"><?= htmlspecialchars($video['title']) ?></div>
            <div class="date"><?= date('M j, Y', strtotime($video['created_at'])) ?></div>
        </div>

    </div>

</a>
                            <?php endforeach; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php if (!empty($rightVideos)): ?>
                    <div class="video-track-wrapper">
                        <div class="video-track video-track--right">
                            <?php for ($i = 0; $i < 2; $i++): ?>
                            <?php foreach ($rightVideos as $video): ?>
                            <a href="wishclusive-single.php?slug=<?= htmlspecialchars($video['slug']) ?>" class="video-card">
                                <div class="thumbnail">
                                    <?php if ($video['thumbnail']): ?>
                                    <img src="<?= htmlspecialchars($video['thumbnail']) ?>" alt="<?= htmlspecialchars($video['title']) ?>" style="width:100%;height:100%;object-fit:cover;position:absolute">
                                    <?php endif; ?>
                                    <span class="material-icons play-icon">play_circle</span>
                                </div>
                                <div class="info">
                                    <div class="artist"><?= htmlspecialchars($video['artist']) ?></div>
                                    <div class="title"><?= htmlspecialchars($video['title']) ?></div>
                                    <div class="date"><?= date('M j, Y', strtotime($video['created_at'])) ?></div>
                                </div>
                            </a>
                            <?php endforeach; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

<section class="about-section">
<a href="news-features.php">
    <img src="assets/banner.png" alt="banner" class="about-image">
</a>
</section>

        <section class="news-section">
            <div class="container">
                <div class="section-header">
                    <a href="news-features.php">
                        <img src="assets/nf.png" alt="news icon" class="section-icon">
                    </a>
                </div>
                <div class="news-grid">
                    <?php foreach ($newsItems as $item): ?>
                    <a href="news-single.php?slug=<?= htmlspecialchars($item['slug']) ?>" class="news-card">
                        <div class="thumbnail">
                            <?php if ($item['image']): ?>
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" style="width:100%;height:100%;object-fit:cover;position:absolute">
                            <?php else: ?>
                            <span class="material-icons">article</span>
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <div class="category"><?= htmlspecialchars($item['category_name'] ?? 'News') ?></div>
                            <div class="title"><?= htmlspecialchars($item['title']) ?></div>
                            <div class="excerpt"><?= htmlspecialchars(truncate(strip_tags($item['excerpt'] ?: $item['content']), 120)) ?></div>
                            <div class="date"><?= date('M j, Y', strtotime($item['created_at'])) ?></div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php if (!empty($recentWishes)): ?>
        <section class="wishes-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Recent Wishes</h2>
                    <a href="wishes.php" class="section-link">View all &rarr;</a>
                </div>
                <div class="wishes-mini-grid">
                    <?php foreach ($recentWishes as $w): ?>
                    <div class="wish-mini-card">
                        <div class="wish-mini-icon">
                            <span class="material-icons"><?= $w['wish_type'] == 'song' ? 'music_note' : 'favorite' ?></span>
                        </div>
                        <p class="wish-mini-message">"<?= htmlspecialchars(truncate($w['message'], 100)) ?>"</p>
                        <div class="wish-mini-name">- <?= htmlspecialchars($w['name']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        
<?php include 'footer.php'; ?>
