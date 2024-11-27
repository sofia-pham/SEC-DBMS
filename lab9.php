<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
// Create connection to Oracle
$conn = oci_connect('s3pham', '10080284',
'(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle12c.cs.torontomu.ca)(Port=1521))(CONNECT_DATA=(SID=orcl12c)))');
if (!$conn) {
    $m = oci_error();
    echo $m['message'];
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lab 9</title>
</head>
<body>
    <a href="create.php">
        <button>Create Tables</button>
    </a>
    <a href="populate.php">
        <button>Populate Tables</button>
    </a>

    <a href="drop.php">
        <button>Drop Tables</button>
    </a>
    <form action="query.php" method="POST">
        <label for="sql_query">Enter SQL Query:</label><br>
        <textarea id="sql_query" name="sql_query" rows="4" cols="50" placeholder="Write your SQL search query here"></textarea><br><br>
        <button type="submit">Submit Query</button>
    </form>
</body>
</html>