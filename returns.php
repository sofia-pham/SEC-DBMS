<?php
require 'connect.php';
$conn = connect();
if (!$conn) {
    die("Connection failed.");
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    $delete_query = "DELETE FROM Return_Details WHERE return_id = :delete_id";
    $delete_stid = oci_parse($conn, $delete_query);
    oci_bind_by_name($delete_stid, ":delete_id", $delete_id);
    
    if (oci_execute($delete_stid)) {
        oci_commit($conn);
        echo "Return with ID $delete_id has been deleted.<br>";
    } else {
        echo "Error deleting return with ID $delete_id.<br>";
    }

    header("Location: returns.php"); // Redirect back to the page after deletion
    exit();
}

$search = $_GET['search'] ?? '';
$sql = "
    SELECT rd.return_id, c.first_name || ' ' || c.last_name AS customer_name,
           e.first_name || ' ' || e.last_name AS employee_name,
           TO_CHAR(rd.return_date, 'MM-DD-YYYY') AS return_date, 
           p.product_name, rd.quantity, rd.total_refund
    FROM Return_Details rd
    JOIN Customers c ON rd.customer_id = c.customer_id
    JOIN Employees e ON rd.employee_id = e.employee_id
    JOIN Products p ON rd.product_id = p.product_id
";

if (!empty($search)) {
    if (is_numeric($search)) {
        $sql .= " WHERE rd.return_id = :search_id";
    } else {
        $sql .= " WHERE LOWER(c.first_name || ' ' || c.last_name) LIKE LOWER(:search_name)";
    }
}

$stid = oci_parse($conn, $sql);

if (!empty($search)) {
    if (is_numeric($search)) {
        oci_bind_by_name($stid, ":search_id", $search);
    } else {
        $searchLike = "%$search%";
        oci_bind_by_name($stid, ":search_name", $searchLike);
    }
}
oci_execute($stid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>South East Collective: View and Search Returns</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header>
    <h2>Returns</h2>
</header>

<body>
    <div class="container dashboard-content">
    <form method="GET" style="text-align: center; margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Search by Name or Return ID" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" style="width: auto;">Search</button>
    </form>

    <table style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead style="background-color: #ecf0f1;">
        <tr>
            <th>Return ID</th>
            <th>Customer</th>
            <th>Employee</th>
            <th>Date</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Refund ($)</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = oci_fetch_assoc($stid)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['RETURN_ID']) ?></td>
                <td><?= htmlspecialchars($row['CUSTOMER_NAME']) ?></td>
                <td><?= htmlspecialchars($row['EMPLOYEE_NAME']) ?></td>
                <td><?= htmlspecialchars($row['RETURN_DATE']) ?></td>
                <td><?= htmlspecialchars($row['PRODUCT_NAME']) ?></td>
                <td><?= htmlspecialchars($row['QUANTITY']) ?></td>
                <td><?= htmlspecialchars($row['TOTAL_REFUND']) ?></td>
                <td>
                    <form method="GET" action="returns.php" onsubmit="return confirm('Are you sure you want to delete this order?');">
                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['RETURN_ID']) ?>">
                        <button type="submit" style="width:90%; background-color: #c0392b;">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <div class="home-button-container">
            <a href="index.php" class="home-button">Return to Main Menu</a>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 South East Collective | All Rights Reserved</p>
    </footer>
</body>
</html>
