<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];

    $stmt = $conn->prepare("INSERT INTO experts (username, password, name, email, usertype) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $password, $name, $email, $usertype);

    if ($stmt->execute()) {
        $message = "<div class='success'>Registration successful. <a href='login.php'>Login now</a></div>";
    } else {
        $message = "<div class='error'>Error: " . htmlspecialchars($conn->error) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expert Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef1f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: #ffffff;
            padding: 30px;
            width: 400px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #2c3e50;
        }
        input, select, button {
            width: 100%;
            margin: 10px 0;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #219150;
        }
        .success {
            text-align: center;
            color: green;
            margin-bottom: 10px;
        }
        .error {
            text-align: center;
            color: red;
            margin-bottom: 10px;
        }
        a {
            color: #2980b9;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Register Forensic User</h2>
        <?php if (!empty($message)) echo $message; ?>
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="text" name="name" placeholder="Full Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <select name="usertype" required>
            <option value="">Select Role</option>
            <option value="expert">Expert</option>
            <option value="higher_authority">Higher Authority</option>
        </select>
        <button type="submit">Register</button>
    </form>
</body>
</html>
