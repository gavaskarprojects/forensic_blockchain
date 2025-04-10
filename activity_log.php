<?php
session_start();
include 'db.php';

if (!isset($_SESSION['expert_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch current user info (for welcome banner)
$expert_id = $_SESSION['expert_id'];
$user_info_stmt = $conn->prepare("SELECT username, usertype FROM experts WHERE expert_id = ?");
$user_info_stmt->bind_param("i", $expert_id);
$user_info_stmt->execute();
$user_info_result = $user_info_stmt->get_result();
$user = $user_info_result->fetch_assoc();

// Fetch activity logs
$stmt = $conn->prepare("SELECT action, timestamp FROM activity_log WHERE expert_id = ? ORDER BY timestamp DESC");
$stmt->bind_param("i", $expert_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Activity Log</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f9; }
        .container {
            width: 80%;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
        .info-bar {
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: #27ae60;
            padding: 10px 16px;
            border-radius: 6px;
        }
        a:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Activity Log</h2>
        <div class="info-bar">
            Logged in as <strong><?= htmlspecialchars($user['username']) ?></strong> (<?= htmlspecialchars($user['usertype']) ?>)
        </div>
        <table>
            <tr>
                <th>Action</th>
                <th>Timestamp</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['action']) ?></td>
                    <td><?= $row['timestamp'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="home.php">← Back to Home</a>
    </div>
</body>
</html>
