<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logging Out...</title>
    <meta http-equiv="refresh" content="2;url=login.php">
    <style>
        body {
            background-color: #111;
            color: #00ffc3;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message {
            text-align: center;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px #00ffc3;
        }
    </style>
</head>
<body>
    <div class="message">
        <h2>Logging you out...</h2>
        <p>Redirecting to login page.</p>
    </div>
</body>
</html>
