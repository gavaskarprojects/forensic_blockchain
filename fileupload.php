<?php
session_start();
include 'db.php';

if (!isset($_SESSION['expert_id'])) {
    header("Location: login.php");
    exit();
}

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['forensic_file'])) {
    $file = $_FILES['forensic_file'];
    $uploadDir = 'uploads/';
    $filePath = $uploadDir . basename($file['name']);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $stmt = $conn->prepare("INSERT INTO uploaded_files (expert_id, file_name, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $_SESSION['expert_id'], $file['name'], $filePath);
        $stmt->execute();

        $file_id = $conn->insert_id;
        $ipfs_hash = md5($file['name'] . time()); // Simulate IPFS hash

        $stmt = $conn->prepare("INSERT INTO ipfs_storage (file_id, ipfs_hash) VALUES (?, ?)");
        $stmt->bind_param("is", $file_id, $ipfs_hash);
        $stmt->execute();

        $action = "Uploaded file '{$file['name']}' with IPFS hash $ipfs_hash";
        $stmt = $conn->prepare("INSERT INTO activity_log (expert_id, action) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION['expert_id'], $action);
        $stmt->execute();

        $success = "✅ File uploaded and stored successfully with simulated IPFS hash!";
    } else {
        $error = "❌ Failed to upload file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Forensic File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
        }
        .container {
            width: 450px;
            margin: 50px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }
        h3 {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            margin: -25px -25px 20px;
            border-radius: 12px 12px 0 0;
        }
        input[type="file"], button {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #27ae60;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #219150;
        }
        .msg {
            padding: 10px;
            color: #2e7d32;
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            border-radius: 5px;
            text-align: center;
        }
        .error {
            padding: 10px;
            color: #c62828;
            background: #ffebee;
            border: 1px solid #ef9a9a;
            border-radius: 5px;
            text-align: center;
        }
        .back-link {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: white;
            background-color: #3498db;
            padding: 10px 15px;
            border-radius: 6px;
        }
        .back-link:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Upload Forensic File</h3>
        <?php if ($success): ?>
            <div class="msg"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="forensic_file" required />
            <button type="submit">Upload</button>
        </form>
        <a class="back-link" href="home.php">← Back to Dashboard</a>
    </div>
</body>
</html>
