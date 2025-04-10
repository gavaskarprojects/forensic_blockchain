<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];

    $stmt = $conn->prepare("SELECT * FROM experts WHERE username=? AND usertype=?");
    $stmt->bind_param("ss", $username, $usertype);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['expert_id'] = $row['expert_id'];
            $_SESSION['usertype'] = $row['usertype'];
            header("Location: home.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found or role mismatch!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Forensic Chain</title>
    <style>
        body {
            background: #0f0f0f;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            width: 320px;
            box-shadow: 0 0 15px #00ffc3;
        }
        .login-box h2 {
            margin-bottom: 20px;
            color: #00ffc3;
            text-align: center;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #2a2a2a;
            border: 1px solid #555;
            color: #fff;
            border-radius: 6px;
        }
        button {
            background: #00ffc3;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #00e6b0;
        }
        .error {
            margin-top: 10px;
            color: #ff4d4d;
            font-size: 0.9em;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Forensic Chain Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="usertype" required>
            <option value="">Select Role</option>
            <option value="expert">Expert</option>
            <option value="higher_authority">Higher Authority</option>
        </select>
        <button type="submit">Login</button>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    </form>
</div>
</body>
</html>
