<?php
require 'connect.php';
$conn = connect();
if (!$conn) {
    die("Connection failed.");
}

$customer_id = $_GET['customer_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['first_name', 'last_name', 'email', 'phone'];
    $updates = [];

    foreach ($fields as $field) {
        if (!empty($_POST[$field])) {
            $value = $_POST[$field];
            if ($field == 'hire_date') {
                $updates[] = "$field = TO_DATE('$value', 'YYYY-MM-DD')";
            } elseif ($field == 'salary') {
                $updates[] = "$field = $value";
            } else {
                $updates[] = "$field = '$value'";
            }
        }
    }

    if (!empty($updates)) {
        $update_query = "UPDATE Customers SET " . implode(', ', $updates) . " WHERE customer_id = :id";
        $stid = oci_parse($conn, $update_query);
        oci_bind_by_name($stid, ":id", $customer_id);
        oci_execute($stid);
        oci_commit($conn);
        echo "Customer updated successfully.<br><br>";
    } else {
        echo "No fields selected to update.<br><br>";
    }
}

$query = "SELECT * FROM Customers WHERE customer_id = :id";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":id", $customer_id);
oci_execute($stid);
$customer = oci_fetch_assoc($stid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>South East Collective: Edit Customer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header>
<h2>Edit Customer Information (ID: <?= htmlspecialchars($customer_id) ?>)</h2>
</header>

<body>
    <div class="container">
    <form method="post">
        <label for="first_name">First Name: </label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($customer['FIRST_NAME']) ?>"><br>

        <label for="last_name">Last Name: </label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($customer['LAST_NAME']) ?>"><br>

        <label for="email">Email: </label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($customer['EMAIL']) ?>"><br>

        <label for="phone">Phone: </label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($customer['PHONE']) ?>"><br>

        <button type="submit">Submit Changes</button>
    </form>

    <div class="home-button-container">
    <a href="select_customers.php" class="home-button">Return to Customer Select</a>
    <a href="index.php" class="home-button">Return to Main Menu</a>
    </div>

    </div>

    <footer>
    <p>&copy; 2024 South East Collective | All Rights Reserved</p>
</footer>
</body>
</html>