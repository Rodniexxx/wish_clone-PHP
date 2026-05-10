<?php
require_once 'config.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $wish_type = $_POST['wish_type'] ?? 'song';
    $song_artist = trim($_POST['song_artist'] ?? '');
    $song_title = trim($_POST['song_title'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $honeypot = trim($_POST['website'] ?? '');

    $errors = [];
    if ($honeypot) {
        $errors[] = 'Bot detected.';
    }
    if (!$name) {
        $errors[] = 'Name is required.';
    }
    if (!$message) {
        $errors[] = 'Message is required.';
    }

    if (empty($errors)) {
        insert("INSERT INTO wishes (name, email, wish_type, song_artist, song_title, message, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')",
            [$name, $email, $wish_type, $song_artist, $song_title, $message]);
        $_SESSION['wish_success'] = true;
    } else {
        $_SESSION['wish_errors'] = $errors;
    }

    $referrer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header("Location: $referrer");
    exit;
}

$pageTitle = 'Wishes &amp; Greetings';
$pageDesc = 'Read wishes and song requests from Wish 107.5 listeners.';
include 'header.php';

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 12;
$offset = ($page - 1) * $perPage;

$total = fetchOne("SELECT COUNT(*) as count FROM wishes WHERE status = 'approved' ORDER BY created_at DESC");
$totalPages = ceil($total['count'] / $perPage);

$wishes = fetchAll("SELECT * FROM wishes WHERE status = 'approved' ORDER BY created_at DESC LIMIT ? OFFSET ?", [$perPage, $offset]);
?>
        <section class="page-header">
            <div class="container">
                <h1>Wishes &amp; Greetings</h1>
                <p>Read wishes and song requests from fellow listeners</p>
            </div>
        </section>

        <section class="content-section">
            <div class="container">
                <?php if (empty($wishes)): ?>
                <div style="text-align:center;padding:60px 0;color:var(--text-muted)">
                    <span class="material-icons" style="font-size:64px;margin-bottom:16px">sentiment_satisfied</span>
                    <p style="font-size:18px">No wishes yet. Be the first to send one!</p>
                </div>
                <?php else: ?>
                <div class="wishes-grid">
                    <?php foreach ($wishes as $w): ?>
                    <div class="wish-card">
                        <div class="wish-card-header">
                            <span class="wish-card-icon material-icons"><?= $w['wish_type'] == 'song' ? 'music_note' : 'favorite' ?></span>
                            <span class="wish-card-type"><?= $w['wish_type'] == 'song' ? 'Song Request' : 'Personal Wish' ?></span>
                        </div>
                        <p class="wish-card-message">"<?= htmlspecialchars($w['message']) ?>"</p>
                        <div class="wish-card-footer">
                            <span class="wish-card-name">- <?= htmlspecialchars($w['name']) ?></span>
                            <?php if ($w['wish_type'] == 'song' && $w['song_title']): ?>
                            <span class="wish-card-song">Requesting: <?= htmlspecialchars($w['song_title']) ?> by <?= htmlspecialchars($w['song_artist']) ?></span>
                            <?php endif; ?>
                            <span class="wish-card-date"><?= date('M j, Y', strtotime($w['created_at'])) ?></span>
                        </div>
                    </div>
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
                <?php endif; ?>
            </div>
        </section>
<?php include 'footer.php'; ?>
