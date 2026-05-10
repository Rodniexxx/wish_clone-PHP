        </main>

        <footer class="footer">
            <div class="container">
                <div class="footer-top">
                    <div class="footer-brand">
                        <img src="https://cdn.prod.website-files.com/66e1987f36e4944240bc5ab8/6701637328a69477c92c2652_Wish-Logo.svg" alt="Wish 107.5" width="48">
                        <p>Wish 107.5 is an FM radio station in the Philippines. Since launching in 2014, it has grown to become a leading music brand, with the Wish Bus, the Wish Music Awards, and wish-granting as its flagship endeavors.</p>
                        <p>Wish 107.5 is operated by Breakthrough and Milestones Productions International (BMPI), Inc.</p>
                    </div>
                    <div>
                        <h4>Links</h4>
                        <ul class="footer-links">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="wishclusives.php">Wishclusives</a></li>
                            <li><a href="news-features.php">News &amp; Features</a></li>
                            <li><a href="shows.php">Shows</a></li>
                            <li><a href="artists.php">Artists</a></li>
                            <li><a href="wishes.php">Wishes</a></li>
                            <li><a href="about-us.php">About Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms and Conditions</a></li>
                            <li><a href="#">Wish Awards</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Follow Us</h4>
                        <ul class="footer-links">
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Instagram</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">YouTube</a></li>
                            <li><a href="#">TikTok</a></li>
                        </ul>
                        <div class="footer-social">
                            <a href="#" aria-label="Facebook">FB</a>
                            <a href="#" aria-label="Instagram">IG</a>
                            <a href="#" aria-label="Twitter">X</a>
                            <a href="#" aria-label="YouTube">YT</a>
                            <a href="#" aria-label="TikTok">TT</a>
                        </div>
                    </div>
                    <div>
                        <h4>Get in Touch</h4>
                        <ul class="footer-links">
                            <li><a href="mailto:sales@wish1075.com">sales@wish1075.com</a></li>
                            <li><a href="mailto:wishbus@wish1075.com">wishbus@wish1075.com</a></li>
                            <li><a href="tel:+63283966688">+632 8396 6688</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; <?= date('Y') ?> Wish 107.5. All rights reserved.</p>
                    <div class="footer-legal">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms and Conditions</a>
                        <a href="#">Cookie Settings</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="wish-modal-overlay" id="wishModal">
        <div class="wish-modal">
            <button class="wish-modal-close" id="wishModalClose"><span class="material-icons">close</span></button>
            <div class="wish-modal-content">
                <h2>Make a Wish</h2>
                <p>Send a song request or a personal wish to Wish 107.5</p>
                <?php if (isset($_SESSION['wish_success']) && $_SESSION['wish_success']): ?>
                <div class="wish-success">Your wish has been sent! It will appear after admin approval.</div>
                <?php unset($_SESSION['wish_success']); ?>
                <?php elseif (isset($_SESSION['wish_errors'])): ?>
                <div class="wish-error">
                    <?php foreach ($_SESSION['wish_errors'] as $err): ?>
                    <p><?= htmlspecialchars($err) ?></p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['wish_errors']); ?>
                <?php endif; ?>
                <form action="wishes.php" method="POST" class="wish-form">
                    <div class="wish-type-toggle">
                        <label class="wish-type-option <?= !isset($_POST['wish_type']) || $_POST['wish_type'] == 'song' ? 'active' : '' ?>">
                            <input type="radio" name="wish_type" value="song" <?= !isset($_POST['wish_type']) || $_POST['wish_type'] == 'song' ? 'checked' : '' ?>>
                            <span class="material-icons">music_note</span>
                            <span>Song Request</span>
                        </label>
                        <label class="wish-type-option <?= isset($_POST['wish_type']) && $_POST['wish_type'] == 'wish' ? 'active' : '' ?>">
                            <input type="radio" name="wish_type" value="wish" <?= isset($_POST['wish_type']) && $_POST['wish_type'] == 'wish' ? 'checked' : '' ?>>
                            <span class="material-icons">favorite</span>
                            <span>Personal Wish</span>
                        </label>
                    </div>
                    <div class="wish-form-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="wish-form-group">
                        <input type="email" name="email" placeholder="Your Email (optional)">
                    </div>
                    <div class="wish-song-fields" id="wishSongFields">
                        <div class="wish-form-row">
                            <div class="wish-form-group">
                                <input type="text" name="song_title" placeholder="Song Title">
                            </div>
                            <div class="wish-form-group">
                                <input type="text" name="song_artist" placeholder="Artist Name">
                            </div>
                        </div>
                    </div>
                    <div class="wish-form-group">
                        <textarea name="message" placeholder="Your message or wish..." required rows="4"></textarea>
                    </div>
                    <div style="display:none">
                        <input type="text" name="website" value="" tabindex="-1" autocomplete="off">
                    </div>
                    <button type="submit" class="btn wish-submit-btn"><span class="material-icons">send</span> Send Wish</button>
                </form>
            </div>
        </div>
    </div>

    <div class="cookie-consent" id="cookieConsent">
        <div class="container">
            <p>By using our website, you acknowledge that you have read and agree to our Privacy Policy. We are committed to protecting your data and ensuring your privacy while delivering an enjoyable music experience.</p>
            <button class="btn" id="cookieAccept">Accept</button>
        </div>
    </div>

    <div id="yt-player"></div>
    <script src="assets/js/script.js"></script>
</body>
</html>
