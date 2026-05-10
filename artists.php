<?php
require_once 'config.php';
require_once 'db.php';
$pageTitle = 'Artists';
$pageDesc = 'Browse the A-Z directory of artists who performed on Wish 107.5.';
include 'header.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search) {
    $artists = fetchAll("SELECT * FROM artists WHERE status = 'published' AND name LIKE ? ORDER BY name ASC", ["%$search%"]);
} else {
    $artists = fetchAll("SELECT * FROM artists WHERE status = 'published' ORDER BY name ASC");
}

$grouped = [];
foreach ($artists as $a) {
    $letter = strtoupper(substr($a['name'], 0, 1));
    if (!isset($grouped[$letter])) {
        $grouped[$letter] = [];
    }
    $grouped[$letter][] = $a;
}
ksort($grouped);

$alphabet = range('A', 'Z');
?>
        <section class="page-header">
            <div class="container">
                <h1>Artists</h1>
                <p>A-Z directory of artists who performed on Wish 107.5</p>
            </div>
        </section>

        <section class="content-section">
            <div class="container">
                <div class="artist-search-bar">
                    <form method="GET" class="artist-search-form">
                        <span class="material-icons artist-search-icon">search</span>
                        <input type="text" name="search" class="artist-search-input" id="artistSearch" placeholder="Search artists..." value="<?= htmlspecialchars($search) ?>" autocomplete="off">
                        <?php if ($search): ?>
                        <a href="artists.php" class="artist-search-clear">Clear</a>
                        <?php endif; ?>
                    </form>
                </div>

                <?php if (empty($artists)): ?>
                <div style="text-align:center;padding:60px 0;color:var(--text-muted)">
                    <p style="font-size:18px">No artists found<?= $search ? ' matching "' . htmlspecialchars($search) . '"' : '' ?>.</p>
                </div>
                <?php else: ?>
                <div class="artist-alphabet" id="artistAlphabet">
                    <?php foreach ($alphabet as $letter): ?>
                    <a href="#letter-<?= $letter ?>" class="artist-alpha-link <?= isset($grouped[$letter]) ? '' : 'artist-alpha-link--empty' ?>" data-letter="<?= $letter ?>"><?= $letter ?></a>
                    <?php endforeach; ?>
                </div>

                <div class="artist-grid" id="artistGrid">
                    <?php foreach ($grouped as $letter => $items): ?>
                    <div class="artist-letter-group" data-letter="<?= $letter ?>">
                        <h2 class="artist-letter-heading" id="letter-<?= $letter ?>"><?= $letter ?></h2>
                        <div class="artist-list">
                            <?php foreach ($items as $artist): ?>
                            <a href="artist-single.php?slug=<?= htmlspecialchars($artist['slug']) ?>" class="artist-card">
                                <div class="artist-card-avatar">
                                    <?php if ($artist['image']): ?>
                                    <img src="<?= htmlspecialchars($artist['image']) ?>" alt="<?= htmlspecialchars($artist['name']) ?>">
                                    <?php else: ?>
                                    <span class="material-icons">person</span>
                                    <?php endif; ?>
                                </div>
                                <div class="artist-card-info">
                                    <div class="artist-card-name"><?= htmlspecialchars($artist['name']) ?></div>
                                    <?php if ($artist['genre']): ?>
                                    <div class="artist-card-genre"><?= htmlspecialchars($artist['genre']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </section>
<?php include 'footer.php'; ?>
