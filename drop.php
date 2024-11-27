<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lab 9</title>
</head>

<body>
    <h1>Drop Tables</h1>

    <?php
    error_reporting(E_ALL);
    // Create connection to Oracle
    $conn = oci_connect('ccaranda', '07253552', 
        '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle12c.cs.torontomu.ca)(Port=1521))(CONNECT_DATA=(SID=orcl12c)))'
    );
    if (!$conn) {
        $m = oci_error();
        echo $m['message'];
        die();
        
    } else {
        $queries = [
            "DROP TABLE ORDER_DETAILS",
            "DROP TABLE INVENTORY",
            "DROP TABLE RETURN_DETAILS",
            "DROP TABLE EMPLOYEES",
            "DROP TABLE PRODUCTS",
            "DROP TABLE CUSTOMERS"
        ];

        foreach ($queries as $query) {
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);

            if (!$r) {
                echo "Error Dropping Tables: Tables do not exist! <br>";
                break;
            }
        }

        if ($r) {
            echo "All tables were successfully dropped! <br>";
        }
        oci_commit($conn);
    }


    ?>
    <br>
    <a href="lab9.php">
        <button>Back</button>
    </a>
</body>
</html>