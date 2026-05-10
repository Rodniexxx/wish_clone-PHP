<?php
require_once 'config.php';
require_once 'db.php';
$pageTitle = 'Wishclusives';
$pageDesc = 'Enjoy fresh Wish Bus videos and more. Indulge in top-notch performances recorded live from and beyond the Wish Bus.';
include 'header.php';

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 12;
$offset = ($page - 1) * $perPage;

$total = fetchOne("SELECT COUNT(*) as count FROM videos WHERE status = 'published'");
$totalPages = ceil($total['count'] / $perPage);

$videos = fetchAll("SELECT * FROM videos WHERE status = 'published' ORDER BY created_at DESC LIMIT ? OFFSET ?", [$perPage, $offset]);
?>
        <section class="page-header">
            <div class="container">
                <h1>Wishclusives</h1>
                <p>Enjoy fresh Wish Bus videos and more</p>
                <p style="margin-top:8px;color:var(--text-muted);font-size:14px">Indulge in top-notch performances recorded live from and beyond the Wish Bus. Made by music lovers for music lovers like you.</p>
            </div>
        </section>

        <section class="content-section">
            <div class="container">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">Latest</h2>
                        <p class="section-subtitle">Enjoy fresh Wish Bus videos and more</p>
                    </div>
                </div>
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
                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">Previous</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'current' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>">Next</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </section>
<?php include 'footer.php'; ?>
