<?php
require 'connect.php';
$conn = connect();
if (!$conn) {
    die("Connection failed.");
}

$tables = ['Return_Details', 'Order_Details', 'Inventory', 'Products', 'Employees', 'Customers', 'Admins'];
foreach ($tables as $tbl) {
    $query = "DROP TABLE $tbl CASCADE CONSTRAINTS";
    $stid = oci_parse($conn, $query);
    oci_execute($stid);
}
echo "All tables dropped!";
?>
<a href="index.php">Back to Main Menu</a>
