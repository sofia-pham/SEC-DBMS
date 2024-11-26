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
    <a href="query.php">
        <button>Query Tables</button>
    </a>
    <a href="drop.php">
        <button>Drop Tables</button>
    </a>
</body>
</html>