<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'wish1075');
define('DB_USER', 'root');
define('DB_PASS', '');

define('SITE_URL', 'http://localhost/wish1075');
define('SITE_NAME', 'Wish 107.5');

define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/wish1075/uploads/');
define('UPLOAD_URL', SITE_URL . '/uploads/');

define('RADIO_STREAM_URL', 'https://untv.mmdlive.lldns.net/untv/f55dcf9ae0f542d6a7614893d0c2dd83/manifest.m3u8');
