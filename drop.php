<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lab 9</title>
</head>
<body>
    <h1>Drop Tables</h1>

    <form action='drop.php' method='POST'>
        <label for='table'>Choose a table to drop<br>
            <input type='radio' name='table' value='VENUE' required>VENUE</input><br>
            <input type='radio' name='table' value='TICKET'>TICKET</input><br>
            <input type='radio' name='table' value='PAYMENT'>PAYMENT</input><br>
            <input type='radio' name='table' value='ORDERS'>ORDERS</input><br>
            <input type='radio' name='table' value='ORDERED_TICKETS'>ORDERED_TICKETS</input><br>
            <input type='radio' name='table' value='EVENT'>EVENT</input><br>
            <input type='radio' name='table' value='CUSTOMER'>CUSTOMER</input><br>
            <input type='radio' name='table' value='ALL'>ALL</input><br>
        </label><br>

        <button type='submit'>Drop</button>
    </form>

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
        else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
                $table = htmlspecialchars($_POST['table']);
                
                if ($table == "PAYMENT") {
                    $queries = ["DROP TABLE PAYMENT CASCADE CONSTRAINTS"];
                } elseif ($table == "CUSTOMER") {
                    $queries = ["DROP TABLE Customer CASCADE CONSTRAINTS"];
                } elseif ($table == "VENUE") {
                    $queries = ["DROP TABLE Venue CASCADE CONSTRAINTS"];
                } elseif ($table == "EVENT") {
                    $queries = ["DROP TABLE Event CASCADE CONSTRAINTS"];
                } elseif ($table == "TICKET") {
                    $queries = ["DROP TABLE Ticket CASCADE CONSTRAINTS"];
                } elseif ($table == "ORDERS") {
                    $queries = ["DROP TABLE Orders CASCADE CONSTRAINTS"];
                } elseif ($table == "ORDERED_TICKETS") {
                    $queries = ["DROP TABLE Ordered_Tickets CASCADE CONSTRAINTS"];
                }
                elseif ($table == "ALL") {
                    $queries = ["DROP TABLE Ordered_Tickets CASCADE CONSTRAINTS",
                        "DROP TABLE Orders CASCADE CONSTRAINTS",
                        "DROP TABLE Ticket CASCADE CONSTRAINTS",
                        "DROP TABLE Event CASCADE CONSTRAINTS",
                        "DROP TABLE Customer CASCADE CONSTRAINTS",
                        "DROP TABLE Venue CASCADE CONSTRAINTS",
                        "DROP TABLE PAYMENT CASCADE CONSTRAINTS"];
                }
                foreach ($queries as $query) {
                    $stid = oci_parse($conn, $query);
                    $r = oci_execute($stid);

                    if (!$r) {
                        $m = oci_error();
                        echo $m['message'];
                        break;
                    }
                }

                if ($r) {
                    if ($table == "ALL") {
                        echo "All tables were successfully dropped!";
                    } else {
                        echo "{$table} was successfully dropped!";
                    }
                    oci_commit($conn);
                }
              
            }
        }
    ?>
    <br>
    <a href="510lab9.php">
        <button>Home</button>
    </a>
</body>
</html>