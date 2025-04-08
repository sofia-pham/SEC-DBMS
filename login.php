<?php
session_start();
require 'connect.php';
$error = '';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connect();
    if (!$conn) {
        die("Connection failed.");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT password FROM Admins WHERE username = :username";
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ":username", $username);
    oci_execute($stid);

    if ($row = oci_fetch_array($stid, OCI_ASSOC)) {
        if ($password === $row['PASSWORD']) {
            $_SESSION['admin'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 12px;
            margin: 10px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #34495e;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Login">
        <div class="error">
            <?= $error ?>
        </div>
    </form>
</div>

</body>
</html>