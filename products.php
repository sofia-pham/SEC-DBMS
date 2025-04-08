<?php
require 'connect.php';
$conn = connect();
if (!$conn) {
    die("Connection failed.");
}

// Handle deletion if delete_id is set
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Delete the product from Products table
    $delete_product_query = "DELETE FROM Products WHERE product_id = :delete_id";
    $delete_stid = oci_parse($conn, $delete_product_query);
    oci_bind_by_name($delete_stid, ":delete_id", $delete_id);

    // Execute the delete query and commit changes
    if (oci_execute($delete_stid)) {
        oci_commit($conn);
        echo "Product with ID $delete_id has been deleted.<br>";
    } else {
        echo "Error deleting product with ID $delete_id.<br>";
    }

    header("Location: view_products.php"); // Redirect back to the page after deletion
    exit();
}

// Handle updating inventory
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_inventory'])) {
    $product_id = $_POST['product_id'];
    $quantity_in_stock = $_POST['quantity_in_stock'];

    // Update the product's inventory in the Inventory table
    $update_inventory_query = "UPDATE Inventory SET quantity_in_stock = :quantity_in_stock WHERE product_id = :product_id";
    $update_stid = oci_parse($conn, $update_inventory_query);
    oci_bind_by_name($update_stid, ":quantity_in_stock", $quantity_in_stock);
    oci_bind_by_name($update_stid, ":product_id", $product_id);

    // Execute the update query and commit changes
    if (oci_execute($update_stid)) {
        oci_commit($conn);
        echo "Inventory for Product ID $product_id updated successfully.<br>";
    } else {
        echo "Error updating inventory for Product ID $product_id.<br>";
    }

    header("Location: view_products.php"); // Redirect back to the page after update
    exit();
}

$search = $_GET['search'] ?? '';
$sql = "
    SELECT p.product_id, p.product_name, i.quantity_in_stock 
    FROM Products p
    LEFT JOIN Inventory i ON p.product_id = i.product_id
";

if (!empty($search)) {
    if (is_numeric($search)) {
        $sql .= " WHERE p.product_id = :search_id";
    } else {
        $sql .= " WHERE LOWER(p.product_name) LIKE LOWER(:search_name)";
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
    <title>South East Collective: View and Search Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header>
    <h2>Products</h2>
</header>
<body>
    <div class="container dashboard-content">
    <form method="GET" style="text-align: center; margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Search by Product ID or Name" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" style="width: auto;">Search</button>
    </form>

    <table style="width: 100%; border-collapse: collapse; text-align: center;">
    <thead style="background-color: #ecf0f1;">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Inventory Quantity</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = oci_fetch_assoc($stid)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['PRODUCT_ID']) ?></td>
                <td><?= htmlspecialchars($row['PRODUCT_NAME']) ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['PRODUCT_ID']) ?>">
                        <input type="number" name="quantity_in_stock" min="0" value="<?= htmlspecialchars($row['QUANTITY_IN_STOCK']) ?>">
                        <button type="submit" name="update_inventory" style="width: auto;">Update Inventory</button>
                    </form>
                </td>
                <td>
                    <form method="GET" action="products.php" onsubmit="return confirm('Are you sure you want to delete this order?');">
                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['PRODUCT_ID']) ?>">
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
