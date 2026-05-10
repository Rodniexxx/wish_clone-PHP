<?php
require_once 'config.php';
require_once 'db.php';
$pageTitle = 'Shows';
$pageDesc = 'Get your daily music fix through our programs';
include 'header.php';

$shows = fetchAll("SELECT * FROM shows WHERE status = 'published' ORDER BY created_at ASC");
?>
        <section class="page-header">
            <div class="container">
                <h1>Radio Schedule</h1>
                <p>Get your daily music fix through our programs</p>
            </div>
        </section>

        <section class="content-section">
            <div class="container">
                <div class="shows-grid">
                    <?php foreach ($shows as $show): ?>
                    <div class="show-card">
                        <div class="day"><?= htmlspecialchars($show['day_of_week']) ?></div>
                        <h3><?= htmlspecialchars($show['title']) ?></h3>
                        <div class="time"><?= htmlspecialchars($show['start_time']) ?> to <?= htmlspecialchars($show['end_time']) ?> <span class="status">On Air</span></div>
                        <p><?= htmlspecialchars($show['description']) ?></p>
                        <div class="dj">Hosted by <?= htmlspecialchars($show['dj_name']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
<?php include 'footer.php'; ?>
