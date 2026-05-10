<?php
require_once 'config.php';

function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    return $pdo;
}

function fetchAll($sql, $params = []) {
    try {
        $stmt = getDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

function fetchOne($sql, $params = []) {
    try {
        $stmt = getDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    } catch (Exception $e) {
        return false;
    }
}

function insert($sql, $params = []) {
    try {
        $stmt = getDB()->prepare($sql);
        $stmt->execute($params);
        return getDB()->lastInsertId();
    } catch (Exception $e) {
        return 0;
    }
}

function execute($sql, $params = []) {
    try {
        $stmt = getDB()->prepare($sql);
        return $stmt->execute($params);
    } catch (Exception $e) {
        return false;
    }
}

function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

function timeAgo($timestamp) {
    $diff = time() - strtotime($timestamp);
    $periods = ['second', 'minute', 'hour', 'day', 'week', 'month', 'year'];
    $lengths = [1, 60, 3600, 86400, 604800, 2630880, 31570560];

    for ($i = count($lengths) - 1; ($i >= 0) && (($num = $lengths[$i]) > $diff); $i--);

    if ($i < 0) $i = 0;
    $num = $lengths[$i];
    $count = floor($diff / $num);
    $period = $periods[$i];
    if ($count > 1) $period .= 's';
    return $count . ' ' . $period . ' ago';
}

function truncate($text, $length = 100) {
    if (strlen($text) <= $length) return $text;
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    return $text . '...';
}

