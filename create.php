<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lab 9</title>
</head>
<body>
    <h1>Create Tables</h1>

    <?php
        error_reporting(E_ALL);
        // Create connection to Oracle
        $conn = oci_connect('s3pham', '10080284',
        '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle12c.cs.torontomu.ca)(Port=1521))(CONNECT_DATA=(SID=orcl12c)))');
        if (!$conn) {
            $m = oci_error();
            echo "Connection Error: " . $m['message'];
            die();
        }
        else {
            $queries = ["CREATE TABLE Customers (
                customer_id INT PRIMARY KEY, 
                first_name VARCHAR(255), 
                last_name VARCHAR(255),
                email VARCHAR(255),
                phone VARCHAR(255)
            )",

            "CREATE TABLE Employees (
                employee_id INT PRIMARY KEY NOT NULL,
                first_name VARCHAR(255),
                last_name VARCHAR(255),
                email VARCHAR(255),
                phone VARCHAR(255),
                hired_position VARCHAR(255),
                hire_date DATE,
                salary DECIMAL
            )",

            "CREATE TABLE Products (
                product_id INT PRIMARY KEY NOT NULL, 
                product_name VARCHAR(255),
                categories VARCHAR(255),
                size_ VARCHAR(255),
                colour VARCHAR(255),
                price DECIMAL
            )", 
                    
            "CREATE TABLE Order_Details (
                order_detail_id INT PRIMARY KEY NOT NULL, 
                order_id INT, 
                customer_id INT,
                employee_id INT,
                order_date TIMESTAMP,
                product_id INT,
                quantity INT,
                purchase_amount DECIMAL,
                total_purchase DECIMAL,
                FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
                FOREIGN KEY (employee_id) REFERENCES Employees(employee_id),
                FOREIGN KEY (product_id) REFERENCES Products(product_id)
            )",
            "CREATE TABLE Return_Details (
                return_detail_id INT PRIMARY KEY NOT NULL, 
                return_id INT, 
                customer_id INT,
                employee_id INT,
                return_date TIMESTAMP,
                product_id INT,
                quantity INT,
                refund_amount DECIMAL,
                total_refund DECIMAL,
                FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
                FOREIGN KEY (employee_id) REFERENCES Employees(employee_id),
                FOREIGN KEY (product_id) REFERENCES Products(product_id)
            )", 
            "CREATE TABLE Inventory (
                inventory_id INT PRIMARY KEY,
                product_id INT, 
                quantity_in_stock INT,
                FOREIGN KEY (product_id) REFERENCES Products(product_id)
            )"];

        foreach ($queries as $query) {
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);

            if (!$r) {
                echo "Error Creating Tables: Tables already exist! <br>";
                break;
            }
        }

        if ($r) {
            echo "All tables were successfully created! <br>";
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