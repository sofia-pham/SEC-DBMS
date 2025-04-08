<?php
require 'connect.php';
$conn = connect();
if (!$conn) {
    die("Connection failed.");
}

$query = "SELECT customer_id, first_name, last_name FROM Customers ORDER BY customer_id";
$stid = oci_parse($conn, $query);
oci_execute($stid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>South East Collective: View and Edit Customers</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<header>
    <h2>Select Customer to Edit</h2>
</header>

<div class="container">
        <form action="edit_customers.php" method="get">
            <label for="customer_id">Customer:</label>
            <select name="customer_id" required>
                <option value="" disabled selected>Select a customer</option>
                <?php while (($row = oci_fetch_assoc($stid)) != false): ?>
                    <option value="<?= $row['CUSTOMER_ID'] ?>">
                        <?= $row['CUSTOMER_ID'] ?> - <?= $row['FIRST_NAME'] ?> <?= $row['LAST_NAME'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Edit</button>
        </form>
    <div class="home-button-container">
    <a href="index.php" class="home-button">Return to Main Menu</a>
    </div>
</div>

<footer>
    <p>&copy; 2024 South East Collective | All Rights Reserved</p>
</footer>

</body>
</html>
