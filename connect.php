<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

function connect() {
    $conn = oci_connect(
        's3pham', 
        '10080284', 
        '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl)))'
    );

    if (!$conn) {
        $e = oci_error();
        die("Oracle connection error: " . $e['message']);
    }

    return $conn;
}
?>