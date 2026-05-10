<?php
require_once 'config.php';
require_once 'db.php';
$pageTitle = 'Livestream';
$pageDesc = 'Listen to Wish 107.5 live streaming';
include 'header.php';
?>
        <section class="page-header livestream-page">
            <div class="container">
                <h1>Livestream</h1>
                <p>Listen to Wish 107.5 live, anytime, anywhere</p>
            </div>
        </section>

        <section class="content-section livestream-page">
            <div class="container">
                <div class="hero-player" style="margin:0 auto 60px">
                    <div class="album-art" style="width:320px;height:320px">
                        <span class="material-icons icon" style="font-size:100px">music_note</span>
                    </div>
                    <div class="status">On Air</div>
                    <div class="song-title">Wish 107.5</div>
                    <div class="artist-name">Live from Manila</div>
                    <div class="player-controls">
                        <button><span class="material-icons">skip_previous</span></button>
                        <button class="play-btn" id="playBtn"><span class="material-icons">play_arrow</span></button>
                        <button class="play-btn" id="pauseBtn" style="display:none"><span class="material-icons">pause</span></button>
                        <button><span class="material-icons">skip_next</span></button>
                    </div>
                    <div style="margin-top:24px">
                        <a href="#" class="hero-btn" style="display:inline-flex;align-items:center;gap:8px">
                            <span class="material-icons">play_circle</span> Listen Now
                        </a>
                    </div>
                </div>
            </div>
        </section>
<?php include 'footer.php'; ?>
