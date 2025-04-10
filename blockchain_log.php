<?php
session_start();
include 'db.php';

if (!isset($_SESSION['expert_id'])) {
    header("Location: login.php");
    exit();
}

$expert_id = $_SESSION['expert_id'];

$stmt = $conn->prepare("
    SELECT id, file_name, ipfs_hash, timestamp  
    FROM blockchain_log 
    WHERE expert_id = ? 
    ORDER BY timestamp DESC
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
    <title>Blockchain Log</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 95%;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #34495e;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .copy-btn, .preview-btn {
            padding: 6px 10px;
            font-size: 12px;
            margin-left: 5px;
            cursor: pointer;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .preview-btn {
            background: #2ecc71;
        }
        .back {
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            font-weight: bold;
            color: #2c3e50;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        .modal-content {
            background: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 60%;
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 22px;
            color: #aaa;
            cursor: pointer;
        }
        .close:hover {
            color: black;
        }
    </style>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert("Hash copied to clipboard!");
            });
        }

        function showModal(fileName, hash, time) {
            document.getElementById('modalFileName').innerText = fileName;
            document.getElementById('modalHash').innerText = hash;
            document.getElementById('modalTime').innerText = time;
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Blockchain File Logs</h2>
    <table>
        <tr>
            <th>File Name</th>
            <th>Hash</th>
            <th>Actions</th>
            <th>Timestamp</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['file_name']) ?></td>
                    <td><?= htmlspecialchars($row['ipfs_hash']) ?></td>
                    <td>
                        <button class="copy-btn" onclick="copyToClipboard('<?= htmlspecialchars($row['ipfs_hash']) ?>')">Copy</button>
                        <a class="preview-btn" href="https://ipfs.io/ipfs/<?= htmlspecialchars($row['ipfs_hash']) ?>" target="_blank">View</a>
                        <button class="preview-btn" onclick="showModal('<?= htmlspecialchars(addslashes($row['file_name'])) ?>', '<?= htmlspecialchars(addslashes($row['ipfs_hash'])) ?>', '<?= date("d M Y, h:i A", strtotime($row['timestamp'])) ?>')">Details</button>
                    </td>
                    <td><?= date("d M Y, h:i A", strtotime($row['timestamp'])) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align:center;">No blockchain logs found.</td></tr>
        <?php endif; ?>
    </table>
    <a class="back" href="home.php">← Back to Dashboard</a>
</div>

<!-- Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h3>File Details</h3>
        <p><strong>File Name:</strong> <span id="modalFileName"></span></p>
        <p><strong>IPFS Hash:</strong> <span id="modalHash"></span></p>
        <p><strong>Timestamp:</strong> <span id="modalTime"></span></p>
    </div>
</div>
</body>
</html>
