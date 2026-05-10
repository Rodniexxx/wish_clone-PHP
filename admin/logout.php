<?php
require_once '../config.php';
session_destroy();
session_start();
session_regenerate_id(true);
header('Location: login.php');
exit;
