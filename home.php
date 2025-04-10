<?php
session_start();
if (!isset($_SESSION['expert_id'])) {
    header("Location: login.php");
    exit();
}
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
        }

        .navbar {
            background-color: #007bff;
            overflow: hidden;
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            margin-right: 10px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: #0056b3;
        }

        .navbar a.logout {
            margin-left: auto;
            background-color: #dc3545;
        }

        .navbar a.logout:hover {
            background-color: #a71d2a;
        }

        .container {
            text-align: center;
            padding: 60px 20px;
        }

        h2 {
            color: #333;
            font-size: 28px;
        }

        .welcome {
            font-size: 18px;
            color: #555;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="home.php">🏠 Home</a>
    <a href="fileupload.php">📁 File Upload</a>
    <a href="ipfs_upload.php">🌐 IPFS Storage</a>
    <a href="blockchain_log.php">🔗 Blockchain</a>
    <a href="logout.php" class="logout">🚪 Logout</a>
</div>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($name); ?>! 🎉</h2>
    <div class="welcome">
        Your GenAI Forensic Dashboard. Securely upload, store, and trace digital evidence using IPFS and Blockchain.
    </div>
</div>

</body>
</html>
