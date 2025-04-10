<?php
session_start();
include 'db.php';

if (!isset($_SESSION['expert_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT u.file_name, u.upload_date, i.ipfs_hash 
          FROM uploaded_files u 
          JOIN ipfs_storage i ON u.file_id = i.file_id 
          WHERE u.expert_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['expert_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Uploaded Files</title>
    <style>
        body {
            background-color: #1e1e1e;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            width: 90%;
            max-width: 900px;
            margin: 50px auto;
            padding: 25px;
            background-color: #2c2c2c;
            border-radius: 12px;
            box-shadow: 0 0 12px #00ffcc;
        }
        h3 {
            text-align: center;
            color: #00ffcc;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1a1a1a;
        }
        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #444;
        }
        th {
            background-color: #00ffcc;
            color: #000;
        }
        tr:hover {
            background-color: #333;
        }
        a.back {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #00ffcc;
            padding: 10px 16px;
            border-radius: 6px;
            color: #000;
            font-weight: bold;
        }
        a.back:hover {
            background: #00e6b8;
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Your Uploaded Files</h3>
    <table>
        <tr>
            <th>File Name</th>
            <th>Upload Date</th>
            <th>IPFS Hash</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['file_name']) ?></td>
            <td><?= htmlspecialchars($row['upload_date']) ?></td>
            <td><?= htmlspecialchars($row['ipfs_hash']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <center><a class="back" href="home.php">← Back to Dashboard</a></center>
</div>
</body>
</html>
