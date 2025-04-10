<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_name = $_POST['file_name'] ?? '';
    $ipfs_hash = $_POST['ipfs_hash'] ?? '';
    $expert_id = $_SESSION['expert_id'] ?? 0;

    if ($file_name && $ipfs_hash && $expert_id) {
        $action = "Added to Blockchain";

        $stmt = $conn->prepare("INSERT INTO blockchain_log (file_name, ipfs_hash, expert_id, action) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssis", $file_name, $ipfs_hash, $expert_id, $action);
            if ($stmt->execute()) {
                header("Location: ipfs_upload.php?success=1");
                exit();
            } else {
                header("Location: ipfs_upload.php?error=insert");
                exit();
            }
        } else {
            header("Location: ipfs_upload.php?error=stmt");
            exit();
        }
    } else {
        header("Location: ipfs_upload.php?error=missing");
        exit();
    }
} else {
    header("Location: ipfs_upload.php");
    exit();
}
