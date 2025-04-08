<?php
require 'connect.php';
$conn = connect();
if (!$conn) {
    die("Connection failed.");
}

$employee_id = $_GET['employee_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['first_name', 'last_name', 'email', 'phone', 'job_title', 'hire_date', 'salary'];
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
        $update_query = "UPDATE Employees SET " . implode(', ', $updates) . " WHERE employee_id = :id";
        $stid = oci_parse($conn, $update_query);
        oci_bind_by_name($stid, ":id", $employee_id);
        oci_execute($stid);
        oci_commit($conn);
        echo "Employee updated successfully.<br><br>";
    } else {
        echo "No fields selected to update.<br><br>";
    }
}

// Fetch current employee data
$query = "SELECT * FROM Employees WHERE employee_id = :id";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":id", $employee_id);
oci_execute($stid);
$employee = oci_fetch_assoc($stid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>South East Collective: Edit Customer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header>
<h2>Edit Employee Information (ID: <?= htmlspecialchars($employee_id) ?>)</h2>
</header>

<body>
    <div class="container">
    <form method="post">
        <label>First Name: <input type="text" name="first_name" value="<?= $employee['FIRST_NAME'] ?>"></label><br>
        <label>Last Name: <input type="text" name="last_name" value="<?= $employee['LAST_NAME'] ?>"></label><br>
        <label>Email: <input type="email" name="email" value="<?= $employee['EMAIL'] ?>"></label><br>
        <label>Phone: <input type="text" name="phone" value="<?= $employee['PHONE'] ?>"></label><br>
        <label>Job Position: <input type="text" name="hired_position" value="<?= $employee['HIRED_POSITION'] ?>"></label><br>
        <label>Hire Date: <input type="date" name="hire_date" value="<?= date('Y-m-d', strtotime($employee['HIRE_DATE'])) ?>"></label><br>
        <label>Salary (Annual): <input type="number" step="0.01" name="salary" value="<?= $employee['SALARY'] ?>"></label><br><br>
        <button type="submit">Submit Changes</button>
    </form>
    <div class="home-button-container">
    <a href="select_employees.php" class="home-button">Return to Employee Select</a>
    <a href="index.php" class="home-button">Return to Main Menu</a>
    </div>
    </div>
    <footer>
        <p>&copy; 2024 South East Collective | All Rights Reserved</p>
    </footer>
</body>
</html>