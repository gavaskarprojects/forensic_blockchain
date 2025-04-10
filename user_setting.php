<?php
session_start();
include('db.php');
if (!isset($_SESSION['expert_id'])) {
    header('Location: login.php');
    exit();
}

$expert_id = $_SESSION['expert_id'];
$message = "";

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE experts SET name = ?, email = ? WHERE expert_id = ?");
    $stmt->bind_param("ssi", $name, $email, $expert_id);
    if ($stmt->execute()) {
        $message = "<div class='success'>Profile updated successfully.</div>";
    } else {
        $message = "<div class='error'>Failed to update profile.</div>";
    }
}

$stmt = $conn->prepare("SELECT * FROM experts WHERE expert_id = ?");
$stmt->bind_param("i", $expert_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Settings</title>
    <style>
        body {
            background: #1e1e1e;
            font-family: Arial, sans-serif;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .settings-box {
            background: #2c2c2c;
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 0 12px #00ffcc;
        }
        h2 {
            text-align: center;
            color: #00ffcc;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
            border: none;
            background: #444;
            color: #fff;
        }
        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #00ffcc;
            color: #000;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #00e6b8;
        }
        .success {
            color: #00ffcc;
            text-align: center;
            margin-bottom: 10px;
        }
        .error {
            color: #ff4d4d;
            text-align: center;
            margin-bottom: 10px;
        }
        a {
            display: block;
            text-align: center;
            color: #00ffcc;
            margin-top: 15px;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="settings-box">
    <h2>Update Profile</h2>
    <?php if (!empty($message)) echo $message; ?>
    <form method="POST">
        <input type="text" name="name" value="<?php echo htmlspecialchars($result['name']); ?>" placeholder="Full Name" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($result['email']); ?>" placeholder="Email" required>
        <button type="submit" name="update">Update</button>
    </form>
    <a href="home.php">← Back to Dashboard</a>
</div>
</body>
</html>
