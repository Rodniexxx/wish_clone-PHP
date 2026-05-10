<?php
require_once 'config.php';
require_once 'db.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$news = fetchOne("SELECT n.*, c.name as category_name FROM news n LEFT JOIN categories c ON n.category_id = c.id WHERE n.slug = ? AND n.status = 'published'", [$slug]);

if (!$news) {
    header('Location: news-features.php');
    exit;
}

$pageTitle = htmlspecialchars($news['title']);
$pageDesc = htmlspecialchars(truncate(strip_tags($news['excerpt'] ?: $news['content']), 150));
include 'header.php';
?>
        <section class="article-content">
            <div class="container">
                <div class="article-header">
                    <div class="category"><?= htmlspecialchars($news['category_name'] ?? 'News') ?></div>
                    <h1><?= htmlspecialchars($news['title']) ?></h1>
                    <div class="date"><?= date('F j, Y', strtotime($news['created_at'])) ?></div>
                </div>
                <?php if ($news['image']): ?>
                <div style="border-radius:8px;overflow:hidden;margin-bottom:32px;max-height:400px">
                    <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" style="width:100%;height:100%;object-fit:cover">
                </div>
                <?php endif; ?>
                <div class="article-body">
                    <?= $news['content'] ?>
                </div>
                <div style="margin-top:40px;padding-top:24px;border-top:1px solid rgba(255,255,255,0.05)">
                    <a href="news-features.php" style="color:var(--brand)">&larr; Back to News &amp; Features</a>
                </div>
            </div>
        </section>
<?php include 'footer.php'; ?>
