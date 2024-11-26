<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lab 9</title>
</head>
<body>
    <h1>Create Tables</h1>

    <form action='create.php' method='POST'>
        <label for='table'>Choose a table to create<br>
            <input type='radio' name='table' value='customers' required>Customers</input><br>
            <input type='radio' name='table' value='employees'>Employees</input><br>
            <input type='radio' name='table' value='products'>Products</input><br>
            <input type='radio' name='table' value='order_details'>Order Details</input><br>
            <input type='radio' name='table' value='return_details'>Return Details</input><br>
            <input type='radio' name='table' value='inventory'>Inventory</input><br>
            <input type='radio' name='table' value='all'>All</input><br>
        </label><br>

        <button type='submit'>Make Table(s)</button>
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
                
                if ($table == "customers") {
                    $queries = ["CREATE TABLE Customers (
                                customer_id INT PRIMARY KEY, 
                                first_name VARCHAR(255), 
                                last_name VARCHAR(255),
                                email VARCHAR(255),
                                phone VARCHAR(255)
                            )"];
                } elseif ($table == "employees") {
                    $queries = ["CREATE TABLE Employees (
                                employee_id INT PRIMARY KEY NOT NULL,
                                first_name VARCHAR(255),
                                last_name VARCHAR(255),
                                email VARCHAR(255),
                                phone VARCHAR(255),
                                hired_position VARCHAR(255),
                                hire_date DATE,
                                salary DECIMAL
                            )"];
                } elseif ($table == "products") {
                    $queries = ["CREATE TABLE Products (
                                product_id INT PRIMARY KEY NOT NULL, 
                                product_name VARCHAR(255),
                                categories VARCHAR(255),
                                size_ VARCHAR(255),
                                colour VARCHAR(255),
                                price DECIMAL
                            )"];
                } elseif ($table == "order_details") {
                    $queries = ["CREATE TABLE Order_Details (
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
                            )"];
                } elseif ($table == "return_details") {
                    $queries = ["CREATE TABLE Return_Details (
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
                            )"];
                } elseif ($table == "inventory") {
                    $queries = ["CREATE TABLE Inventory (
                                inventory_id INT PRIMARY KEY,
                                product_id INT, 
                                quantity_in_stock INT,
                                FOREIGN KEY (product_id) REFERENCES Products(product_id)
                            )"];
                } elseif ($table == "all") {
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
                    ];
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
                        echo "All tables were successfully created!";
                    } else {
                        echo "{$table} was successfully created!";
                    }
                    oci_commit($conn);
                }
            }
        }
    ?>
    <br>
    <a href="lab9.php">
        <button>Home</button>
    </a>
</body>
</html>