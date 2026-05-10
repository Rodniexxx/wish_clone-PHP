var ytPlayer = null;
var isPlaying = false;

function onYouTubeIframeAPIReady() {
    ytPlayer = new YT.Player('yt-player', {
        height: '0',
        width: '0',
        videoId: 'e_mZ2lVMkJs',
        playerVars: {
            autoplay: 0,
            controls: 0,
            disablekb: 1,
            fs: 0,
            modestbranding: 1,
            rel: 0,
            iv_load_policy: 3
        },
        events: {
            onStateChange: onPlayerStateChange
        }
    });
}

function onPlayerStateChange(event) {
    if (event.data === YT.PlayerState.PLAYING) {
        isPlaying = true;
        updateUI(true);
    } else if (event.data === YT.PlayerState.ENDED) {
        ytPlayer.seekTo(0);
        ytPlayer.playVideo();
    } else if (event.data === YT.PlayerState.PAUSED) {
        isPlaying = false;
        updateUI(false);
    }
}

function startPlayback() {
    if (ytPlayer) {
        ytPlayer.playVideo();
    }
}

function stopPlayback() {
    if (ytPlayer) {
        ytPlayer.pauseVideo();
    }
}

function updateUI(playing) {
    var playBtn = document.getElementById('playBtn');
    var pauseBtn = document.getElementById('pauseBtn');
    var livestreamLinks = document.querySelectorAll('.navbar-livestream');
    var onAirStatus = document.querySelector('.status');
    var songTitle = document.querySelector('.song-title');
    var artistName = document.querySelector('.artist-name');

    if (playBtn) playBtn.style.display = playing ? 'none' : 'flex';
    if (pauseBtn) pauseBtn.style.display = playing ? 'flex' : 'none';
    if (onAirStatus) onAirStatus.textContent = playing ? 'Live' : 'On Air';
    if (songTitle) songTitle.textContent = playing ? 'Wish 107.5' : 'Playing now...';
    if (artistName) artistName.textContent = playing ? 'Listening live' : 'Wish 107.5';
    livestreamLinks.forEach(function (link) {
        if (playing) {
            link.innerHTML = '<span class="material-icons icon">pause_circle</span> Playing ...';
        } else {
            link.innerHTML = '<span class="material-icons icon">play_circle</span> Livestream';
        }
        link.style.color = '#fff';
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var playBtn = document.getElementById('playBtn');
    var pauseBtn = document.getElementById('pauseBtn');
    var livestreamLinks = document.querySelectorAll('.navbar-livestream');

    if (playBtn) {
        playBtn.addEventListener('click', startPlayback);
    }

    if (pauseBtn) {
        pauseBtn.addEventListener('click', stopPlayback);
    }

    livestreamLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            if (isPlaying) {
                stopPlayback();
            } else {
                startPlayback();
            }
        });
    });

    // Mobile menu toggle
    var toggleBtn = document.getElementById('navbarToggle');
    var navLinks = document.getElementById('navbarLinks');

    if (toggleBtn && navLinks) {
        toggleBtn.addEventListener('click', function () {
            navLinks.classList.toggle('open');
        });
    }

    // Cookie consent
    var cookieConsent = document.getElementById('cookieConsent');
    var cookieBtn = document.getElementById('cookieAccept');

    if (cookieConsent && !localStorage.getItem('cookieConsent')) {
        cookieConsent.classList.add('show');
    }

    if (cookieBtn) {
        cookieBtn.addEventListener('click', function () {
            localStorage.setItem('cookieConsent', 'true');
            cookieConsent.classList.remove('show');
        });
    }
});

// ======= WISH MODAL =======
function openWishModal() {
    var modal = document.getElementById('wishModal');
    if (modal) modal.classList.add('open');
}
function closeWishModal() {
    var modal = document.getElementById('wishModal');
    if (modal) modal.classList.remove('open');
}

// ======= ARTIST A-Z JUMP =======
function setupArtistJump() {
    var links = document.querySelectorAll('.artist-alpha-link:not(.artist-alpha-link--empty)');
    links.forEach(function (link) {
        link.addEventListener('click', function (e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                var offset = 120;
                var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        });
    });
}

// ======= ARTIST LIVE SEARCH =======
function setupArtistSearch() {
    var searchInput = document.getElementById('artistSearch');
    if (!searchInput) return;
    searchInput.addEventListener('input', function () {
        var query = this.value.trim().toLowerCase();
        var cards = document.querySelectorAll('.artist-card');
        var groups = document.querySelectorAll('.artist-letter-group');
        cards.forEach(function (card) {
            var name = (card.querySelector('.artist-card-name') || {}).textContent || '';
            card.classList.toggle('hidden', query && name.toLowerCase().indexOf(query) === -1);
        });
        groups.forEach(function (group) {
            var visible = Array.from(group.querySelectorAll('.artist-card')).some(function (c) { return !c.classList.contains('hidden'); });
            group.style.display = (!query || visible) ? '' : 'none';
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var playBtn = document.getElementById('playBtn');
    var pauseBtn = document.getElementById('pauseBtn');
    var livestreamLinks = document.querySelectorAll('.navbar-livestream');

    if (playBtn) {
        playBtn.addEventListener('click', startPlayback);
    }

    if (pauseBtn) {
        pauseBtn.addEventListener('click', stopPlayback);
    }

    livestreamLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            if (isPlaying) {
                stopPlayback();
            } else {
                startPlayback();
            }
        });
    });

    // Mobile menu toggle
    var toggleBtn = document.getElementById('navbarToggle');
    var navLinks = document.getElementById('navbarLinks');

    if (toggleBtn && navLinks) {
        toggleBtn.addEventListener('click', function () {
            navLinks.classList.toggle('open');
        });
    }

    // Cookie consent
    var cookieConsent = document.getElementById('cookieConsent');
    var cookieBtn = document.getElementById('cookieAccept');

    if (cookieConsent && !localStorage.getItem('cookieConsent')) {
        cookieConsent.classList.add('show');
    }

    if (cookieBtn) {
        cookieBtn.addEventListener('click', function () {
            localStorage.setItem('cookieConsent', 'true');
            cookieConsent.classList.remove('show');
        });
    }

    // Wish modal triggers
    var wishNavLink = document.getElementById('wishNavLink');
    if (wishNavLink) {
        wishNavLink.addEventListener('click', function (e) {
            e.preventDefault();
            openWishModal();
        });
    }

    var wishModalClose = document.getElementById('wishModalClose');
    if (wishModalClose) {
        wishModalClose.addEventListener('click', closeWishModal);
    }

    var wishModal = document.getElementById('wishModal');
    if (wishModal) {
        wishModal.addEventListener('click', function (e) {
            if (e.target === this) closeWishModal();
        });
    }

    // Set anti-spam time on wish form submission
    var wishForm = document.querySelector('.wish-form');
    if (wishForm) {
        wishForm.addEventListener('submit', function () {
            var timeInput = document.createElement('input');
            timeInput.type = 'hidden';
            timeInput.name = 'wish_time';
            timeInput.value = Math.floor(Date.now() / 1000);
            this.appendChild(timeInput);
        });
    }

    // Wish type toggle
    var wishTypeRadios = document.querySelectorAll('input[name=\"wish_type\"]');
    var songFields = document.getElementById('wishSongFields');
    wishTypeRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            var options = document.querySelectorAll('.wish-type-option');
            options.forEach(function (opt) { opt.classList.remove('active'); });
            this.closest('.wish-type-option').classList.add('active');
            if (songFields) {
                songFields.classList.toggle('hidden', this.value !== 'song');
            }
        });
    });

    // Init song fields visibility
    if (songFields) {
        var checkedSong = document.querySelector('input[name=\"wish_type\"]:checked');
        if (checkedSong && checkedSong.value !== 'song') {
            songFields.classList.add('hidden');
        }
    }

    // Artist A-Z jump
    setupArtistJump();

    // Artist live search
    setupArtistSearch();
});
