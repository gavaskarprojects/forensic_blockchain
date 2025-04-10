<?php
session_start();
include 'db.php';

if (!isset($_SESSION['expert_id'])) {
    header("Location: login.php");
    exit();
}

$expert_id = $_SESSION['expert_id'];

$stmt = $conn->prepare("
    SELECT f.file_name, f.file_path, s.ipfs_hash, s.created_at, s.id AS storage_id 
    FROM uploaded_files f 
    JOIN ipfs_storage s ON f.file_id = s.file_id 
    WHERE f.expert_id = ?
    ORDER BY s.created_at DESC
");

if (!$stmt) {
    die("SQL Prepare Failed: " . $conn->error);
}

$stmt->bind_param("i", $expert_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>IPFS Uploads</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 85%;
            margin: 40px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 12px rgba(0,0,0,0.1);
        }
        h3 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 6px 10px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #219150;
        }
        a.back {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
        a.back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>IPFS Hash Records</h3>
        <?php if (isset($_GET['success'])): ?>
    <div style="background: #dff0d8; color: #3c763d; padding: 10px; margin-bottom: 15px; border: 1px solid #d6e9c6; border-radius: 4px;">
        ✅ File successfully added to blockchain!
    </div>
<?php elseif (isset($_GET['error'])): ?>
    <div style="background: #f2dede; color: #a94442; padding: 10px; margin-bottom: 15px; border: 1px solid #ebccd1; border-radius: 4px;">
        ❌ Error occurred: <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

        <table>
            <tr>
                <th>File Name</th>
                <th>IPFS Hash</th>
                <th>Uploaded At</th>
                <th>View</th>
                <th>Add to Blockchain</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['file_name']) ?></td>
                        <td><?= htmlspecialchars($row['ipfs_hash']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><a class="btn" href="https://ipfs.io/ipfs/<?= $row['ipfs_hash'] ?>" target="_blank">View</a></td>
                        <td>
                            <form action="add_to_blockchain.php" method="POST">
                                <input type="hidden" name="file_name" value="<?= htmlspecialchars($row['file_name']) ?>">
                                <input type="hidden" name="ipfs_hash" value="<?= htmlspecialchars($row['ipfs_hash']) ?>">
                                <button class="btn" type="submit">Add to Blockchain</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align: center;">No IPFS records found.</td></tr>
            <?php endif; ?>
        </table>
        <a class="back" href="home.php">← Back to Dashboard</a>
    </div>
</body>
</html>
