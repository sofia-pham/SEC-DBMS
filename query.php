<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lab 9</title>
</head>

<body>
    <h1>Query</h1>

<?php
error_reporting(E_ALL);

// Create connection to Oracle
$conn = oci_connect(
    's3pham', '10080284', 
    '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle12c.cs.torontomu.ca)(Port=1521))(CONNECT_DATA=(SID=orcl12c)))'
);

if (!$conn) {
    $m = oci_error();
    echo $m['message'];
    die();
}

// Handle the SQL query submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sql_query'])) {
    $sql_query = htmlspecialchars($_POST['sql_query']);  // Sanitize input to prevent XSS

    // Check if the query starts with 'SELECT' or 'INSERT'
    $query_type = strtoupper(trim(substr($sql_query, 0, 6)));  // Extract the first 6 characters to identify the query type
    if ($query_type !== 'SELECT' && $query_type !== 'INSERT') {
        echo "<p style='color: red;'>Only SELECT or INSERT queries are allowed!</p>";
    } else {
        // Parse and execute the SQL query
        $stid = oci_parse($conn, $sql_query);
        
        if (!$stid) {
            $m = oci_error($conn);
            echo "Error parsing SQL query: " . $m['message'];
            die();
        }
    }
    $r = oci_execute($stid);

    if (!$r) {
        $m = oci_error($stid);
        echo "Error executing SQL query: " . $m['message'];
        die();
    }

    // Display the results of the query (if SELECT query)
    if (strpos(strtoupper($sql_query), 'SELECT') === 0) {
        echo "<h3>Query Results:</h3>";
        echo "<table border='1'><tr>";
        
        // Fetch column names and print as table headers
        $ncols = oci_num_fields($stid);
        for ($i = 1; $i <= $ncols; $i++) {
            echo "<th>" . oci_field_name($stid, $i) . "</th>";
        }
        echo "</tr>";

        // Fetch rows and display as table rows
        while ($row = oci_fetch_assoc($stid)) {
            echo "<tr>";
            foreach ($row as $column => $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>Query executed successfully!</h3>";
    }

    // Close the Oracle connection
    oci_free_statement($stid);
    oci_close($conn);
}
?>

<a href="lab9.php">
        <button>Back</button>
    </a>
</body>
</html>