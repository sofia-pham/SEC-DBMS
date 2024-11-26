<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lab 9</title>
</head>
<body>
    <h1>Query Tables</h1>

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
        $query = "SELECT table_name FROM user_tables" ;
        $stid = oci_parse($conn, $query);
        $r = oci_execute($stid);

        if ($r) {
            echo "<form action='query.php' method='post'>
                <label for='table'>Choose a table to query:<br>";
            while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                foreach ($row as $item) {
                    echo "<input type='radio' name='table' value={$item} required>{$item}</input><br>";
                }
            }
            echo "</label><br>
            <label for='search'>Search:
                <input type='text' name='search' value='' placeholder='Search...'></input><br>
            </label><br>
            <button type='submit'>Query</button><br>
            </form><br>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
            $table = htmlspecialchars($_POST['table']);
            
            $query = "SELECT * FROM {$table}" ;
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);

            if ($r && isset($_POST['search'])) {
                $query .= " WHERE ";
                $numCols = oci_num_fields($stid);
                for ($i = 1; $i <= $numCols; $i++) {
                    $colname = oci_field_name($stid, $i);
                    echo $colname;
                    $query .= htmlspecialchars($colname) . " LIKE '%" . htmlspecialchars($_POST['search']) . "%'";
                    if ($i < $numCols) {
                        $query .= " OR ";
                    }
                }

                $stid = oci_parse($conn, $query);
                $r = oci_execute($stid);
            }

            if ($r) {
                $numCols = oci_num_fields($stid);
                echo "<table border='1'>
                    <tr>";

                for ($i = 1; $i <= $numCols; $i++) {
                    $colname = oci_field_name($stid, $i);
                    echo "<th>" . htmlspecialchars($colname) . "</th>";
                }

                echo "</tr>";

                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    echo "<tr>";
                    foreach ($row as $item) {
                        echo "<td>" . $item . "</td>";
                    }
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                $m = oci_error();
                echo $m['message'];
            }
        }
    }
    ?>
    <br>
    <a href="lab9.php">
        <button>Back</button>
    </a>
</body>
</html>