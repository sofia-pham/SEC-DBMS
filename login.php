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
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
<h2>Admin Login</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
    <p style="color:red;">
        <?= $error ?>
    </p>
</form>
</body>
</html>
