<?php
require 'connect.php';
$conn = connect();
if (!$conn) {
    die("Connection failed.");
}

$queries = [
    "CREATE TABLE Admins (
        admin_id INT PRIMARY KEY,
        first_name VARCHAR(255),
        last_name VARCHAR(255),
        username VARCHAR(255) UNIQUE,
        password VARCHAR(255)
    )",
    "CREATE TABLE Customers (
        customer_id INT PRIMARY KEY, 
        first_name VARCHAR(255), 
        last_name VARCHAR(255),
        email VARCHAR(255),
        phone VARCHAR(255)
    )",
    "CREATE TABLE Employees (
        employee_id INT PRIMARY KEY,
        first_name VARCHAR(255),
        last_name VARCHAR(255),
        email VARCHAR(255),
        phone VARCHAR(255),
        hired_position VARCHAR(255),
        hire_date DATE,
        salary DECIMAL
    )",
    "CREATE TABLE Products (
        product_id INT PRIMARY KEY,
        product_name VARCHAR(255),
        categories VARCHAR(255),
        size_ VARCHAR(255),
        colour VARCHAR(255),
        price DECIMAL
    )",
    "CREATE TABLE Order_Details (
        order_detail_id INT PRIMARY KEY, 
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
        return_detail_id INT PRIMARY KEY, 
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
    )"
];

foreach ($queries as $query) {
    $stid = oci_parse($conn, $query);
    oci_execute($stid);
}

oci_commit($conn);
echo "All tables created!";
?>
<a href="index.php">Back to Main Menu</a>