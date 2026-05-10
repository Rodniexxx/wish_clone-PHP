<?php
require_once 'config.php';
require_once 'db.php';
$pageTitle = 'News & Features';
$pageDesc = 'Music happenings, features, and exclusive interviews';
include 'header.php';

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 9;
$offset = ($page - 1) * $perPage;

$total = fetchOne("SELECT COUNT(*) as count FROM news WHERE status = 'published'");
$totalPages = ceil($total['count'] / $perPage);

$newsItems = fetchAll("SELECT n.*, c.name as category_name FROM news n LEFT JOIN categories c ON n.category_id = c.id WHERE n.status = 'published' ORDER BY n.created_at DESC LIMIT ? OFFSET ?", [$perPage, $offset]);
?>
        <section class="page-header">
            <div class="container">
                <h1>News &amp; Features</h1>
                <p>Music happenings, features, and exclusive interviews</p>
            </div>
        </section>

        <section class="content-section">
            <div class="container">
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
                            <div class="excerpt"><?= htmlspecialchars(truncate(strip_tags($item['excerpt'] ?: $item['content']), 150)) ?></div>
                            <div class="date"><?= date('M j, Y', strtotime($item['created_at'])) ?></div>
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
