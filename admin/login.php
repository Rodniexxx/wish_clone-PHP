<?php
require_once '../config.php';
require_once '../db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = fetchOne("SELECT * FROM users WHERE username = ?", [$username]);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Wish 107.5</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #121113;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-box {
            background: #1a1a1e;
            border-radius: 8px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }
        .login-box h1 {
            font-size: 24px;
            margin-bottom: 24px;
            text-align: center;
        }
        .login-box .logo {
            text-align: center;
            margin-bottom: 24px;
        }
        .login-box .logo img { width: 64px; }
        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
            color: #ccc;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            background: #2a2a2e;
            border: 1px solid #444;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            font-family: inherit;
        }
        .form-group input:focus {
            outline: none;
            border-color: #f44329;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #f44329;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
        }
        .btn:hover { background: #b4301e; }
        .error {
            color: #f44329;
            font-size: 14px;
            text-align: center;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">
            <img src="https://cdn.prod.website-files.com/66e1987f36e4944240bc5ab8/6701637328a69477c92c2652_Wish-Logo.svg" alt="Wish 107.5">
        </div>
        <h1>Admin Login</h1>
        <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>
</body>
</html>
