<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require 'connect.php';
$conn = connect();
if (!$conn) {
    die("Connection failed.");
}

$username = $_SESSION['admin'];
$query = "SELECT first_name FROM Admins WHERE username = :username";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":username", $username);
oci_execute($stid);

$admin = oci_fetch_assoc($stid);
$admin_name = $admin['FIRST_NAME']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h2>Welcome, <?= htmlspecialchars($admin_name) ?>!</h2>
</header>

<div class="container">
    <div class="dashboard-content">
        <h3>Management Options</h3>
        <ul>
            <li><a href="select_customers.php">Edit Customers Information</a></li>
            <li><a href="select_employees.php">Edit Employees Information</a></li>
            <li><a href="orders.php">View and Search Orders</a></li>
            <li><a href="returns.php">View and Search Returns</a></li>
            <li><a href="products.php">View and Search Products</a></li>
        </ul>

        <h3>Create and Drop Tables</h3>
        <ul>
            <li><a href="create.php">Create All Tables</a></li>
            <li><a href="drop.php">Drop All Tables</a></li>
        </ul>

        <p style="text-align: center; font-size: 16px; color: #7f8c8d;">Note: Due to data constraints, we must create and drop all tables (no creating or dropping individual table).</p>

        <p style="text-align: center;">
            <a href="populate.php" style="font-size: 18px; color: #2980b9;">Populate All Tables with Dummy Data!</a>
        </p>
    </div>
    <nav>
        <a href="logout.php">Logout</a>
    </nav>
</div>

<footer>
    <p>&copy; 2024 South East Collective | All Rights Reserved.</p>
</footer>

</body>
</html>