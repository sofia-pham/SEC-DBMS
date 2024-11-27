<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Create connection to Oracle database
$conn = oci_connect(
    'ccaranda', 
    '07253552', 
    '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle12c.cs.torontomu.ca)(Port=1521))(CONNECT_DATA=(SID=orcl12c)))'
);

// Check if the connection was successful
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .button-container a button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
        }
        button[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>South East Collective</h1>

    <div class="button-container">
        <a href="create.php">
            <button>Create Tables</button>
        </a>
        <a href="populate.php">
            <button>Populate Tables</button>
        </a>
        <a href="drop.php">
            <button>Drop Tables</button>
        </a>
    </div>

    <form action="query.php" method="POST">
        <label for="sql_query">Enter SQL Query:</label><br><br>
        <textarea id="sql_query" name="sql_query" rows="4" cols="50" placeholder="Write your SQL search query here"></textarea><br><br>
        <button type="submit">Submit Query</button>
    </form>
</body>

</html>
