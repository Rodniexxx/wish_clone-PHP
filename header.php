<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME ?></title>
    <meta name="description" content="<?= isset($pageDesc) ? $pageDesc : 'Wish 107.5 is one of the leading music brands in the Philippines, with the Wish Bus and the Wish Music Awards as its flagship endeavors.' ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="https://cdn.prod.website-files.com/66e1987f36e4944240bc5ab8/670280eb37e52c66c0769ec2_wish1075-logo.png" type="image/x-icon">
    <script src="https://use.typekit.net/ezy3ytb.js"></script>
    <script>try{Typekit.load({async:true})}catch(e){}</script>
    <script src="https://www.youtube.com/iframe_api"></script>
</head>
<body>
    <div class="page-wrapper">
        <nav class="navbar">
            <div class="container">
                <a href="index.php" class="navbar-logo">
                    <img src="https://cdn.prod.website-files.com/66e1987f36e4944240bc5ab8/6701637328a69477c92c2652_Wish-Logo.svg" alt="Wish 107.5">
                </a>
                <ul class="navbar-links" id="navbarLinks">
                    <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Home</a></li>
                    <li><a href="wish-date.php" class="<?= basename($_SERVER['PHP_SELF']) == 'wish-date.php' ? 'active' : '' ?>">Wish Date</a></li>
                    <li><a href="wishclusives.php" class="<?= basename($_SERVER['PHP_SELF']) == 'wishclusives.php' ? 'active' : '' ?>">Wishclusives</a></li>
                    <li><a href="news-features.php" class="<?= basename($_SERVER['PHP_SELF']) == 'news-features.php' ? 'active' : '' ?>">News &amp; Features</a></li>
                    <li><a href="shows.php" class="<?= basename($_SERVER['PHP_SELF']) == 'shows.php' ? 'active' : '' ?>">Shows</a></li>
                    <li><a href="artists.php" class="<?= basename($_SERVER['PHP_SELF']) == 'artists.php' || basename($_SERVER['PHP_SELF']) == 'artist-single.php' ? 'active' : '' ?>">Artists</a></li>
                    <li><a href="javascript:void(0)" id="wishNavLink" class="wish-nav-link">Make a Wish</a></li>
                    <li><a href="wishes.php" class="<?= basename($_SERVER['PHP_SELF']) == 'wishes.php' ? 'active' : '' ?>">Wishes</a></li>
                    <li><a href="about-us.php" class="<?= basename($_SERVER['PHP_SELF']) == 'about-us.php' ? 'active' : '' ?>">About Us</a></li>
                    <li><a href="livestream.php" class="navbar-livestream" style="color: #fff;"><span class="material-icons icon">play_circle</span> Livestream</a></li>
                </ul>
                <button class="navbar-toggle" id="navbarToggle">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
            </div>
        </nav>
        <main>
