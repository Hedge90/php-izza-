<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "pizzadb";

global $conn;
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the table
$createTableSql = "CREATE TABLE IF NOT EXISTS pizza (
    azon INT(5) AUTO_INCREMENT PRIMARY KEY,
    nev VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    telefon VARCHAR(20) NOT NULL,  -- Changed to VARCHAR for phone number
    pizza VARCHAR(50) NOT NULL,
    meret VARCHAR(30) NOT NULL,
    extrasajt TINYINT(1) NOT NULL,
    ido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($createTableSql) === TRUE) {
    echo "Table 'pizza' created or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

?>