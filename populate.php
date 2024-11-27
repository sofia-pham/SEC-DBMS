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
            "INSERT INTO Customers VALUES (1, 'John', 'Smith', 'john.smith@doe.com', '123-456-7890')",
            "INSERT INTO Customers VALUES (2, 'Jane', 'Doe', 'jane.doe@smith.com', '555-555-5555')",
            "INSERT INTO Customers VALUES (3, 'Jason', 'Truong', 'j.truongh@doe.com', '123-456-1234')",
            "INSERT INTO Customers VALUES (4, 'Vivian', 'Fang', 'vivian.fang@doe.com', '123-456-5678')",

            // Insert into Employees
            "INSERT INTO Employees VALUES (1998, 'Sofia', 'Pham', 'sofia.pham98@gmail.com', '199-819-9819', 'Sales Associate', TO_DATE('2020-01-01', 'YYYY-MM-DD'), 50000.00)",
            "INSERT INTO Employees VALUES (2002, 'Carlos', 'Carandang', 'carloscarandang@gmail.com', '200-200-2000', 'Manager', TO_DATE('2019-01-01', 'YYYY-MM-DD'), 80000.00)",
            "INSERT INTO Employees VALUES (2001, 'Justin', 'Orial', 'justin.orial@gmail.com', '200-120-0120', 'Sales Associate', TO_DATE('2019-01-01', 'YYYY-MM-DD'), 50000.00)",

            // Insert into Products
            "INSERT INTO Products VALUES (1, 'T-shirt', 'Clothing', 'M', 'White', 10.00)",
            "INSERT INTO Products VALUES (2, 'Jeans', 'Clothing', 'M', 'Blue', 20.00)",
            "INSERT INTO Products VALUES (3, 'Socks', 'Clothing', 'M', 'Black', 5.00)",
            "INSERT INTO Products VALUES (4, 'Shoes', 'Footwear', 'M', 'Brown', 30.00)",
            "INSERT INTO Products VALUES (5, 'Hat', 'Accessories', 'M', 'Red', 15.00)",
            "INSERT INTO Products VALUES (6, 'Gloves', 'Accessories', 'M', 'Green', 7.00)",
            "INSERT INTO Products VALUES (7, 'Jacket', 'Clothing', 'M', 'Black', 25.00)",
            "INSERT INTO Products VALUES (8, 'Scarf', 'Accessories', 'M', 'Blue', 12.00)",
            "INSERT INTO Products VALUES (9, 'Boots', 'Footwear', 'M', 'Black', 40.00)",
            "INSERT INTO Products VALUES (10, 'Shorts', 'Clothing', 'M', 'White', 15.00)",

            // Insert into Order_Details
            "INSERT INTO Order_Details VALUES (1000, 1, 1, 1998, TO_TIMESTAMP('2020-01-01', 'YYYY-MM-DD HH24:MI:SS'), 1, 2, 20.00, 20.00)",
            "INSERT INTO Order_Details VALUES (1001, 2, 2, 2001, TO_TIMESTAMP('2020-01-01', 'YYYY-MM-DD HH24:MI:SS'), 2, 1, 20.00, 20.00)",

            // Insert into Return_Details
            "INSERT INTO Return_Details VALUES (9999, 1000, 1, 1998, TO_TIMESTAMP('2020-01-03', 'YYYY-MM-DD HH24:MI:SS'), 1, 1, 10.00, 10.00)",

            // Insert into Inventory
            "INSERT INTO Inventory VALUES (100001, 1, 100)",
            "INSERT INTO Inventory VALUES (100002, 2, 50)",
            "INSERT INTO Inventory VALUES (100003, 3, 200)",
            "INSERT INTO Inventory VALUES (100004, 4, 75)",
            "INSERT INTO Inventory VALUES (100005, 5, 150)",
            "INSERT INTO Inventory VALUES (100006, 6, 300)",
            "INSERT INTO Inventory VALUES (100007, 7, 100)",
            "INSERT INTO Inventory VALUES (100008, 8, 50)",
            "INSERT INTO Inventory VALUES (100009, 9, 25)",
            "INSERT INTO Inventory VALUES (100010, 10, 75)"
        ];

        foreach ($queries as $query) {
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            
            if (!$r) {
                $error = oci_error($stid); 
                if (strpos($error['message'], 'ORA-00001') !== false) {
                    echo "Error Populating Tables: Duplicate values found while populating tables! <br>";
                } elseif (strpos($error['message'], 'ORA-00942') !== false) {
                    echo "Error: Tables do not exist. Please create tables before populating it! <br>";
                } 
                break; 
            }

        }

        if ($r) {
            echo "Tables were populated! <br>";
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