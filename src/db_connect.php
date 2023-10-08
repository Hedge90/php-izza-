<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "pizzadb";

global $conn;
global $response;

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $createTableSql = "CREATE TABLE IF NOT EXISTS pizza (
        azon INT(5) AUTO_INCREMENT PRIMARY KEY,
        nev VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        telefon VARCHAR(20) NOT NULL,
        pizza VARCHAR(50) NOT NULL,
        meret VARCHAR(30) NOT NULL,
        extrasajt TINYINT(1) NOT NULL,
        ido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($createTableSql) === FALSE) {
        throw new Exception("Error creating table: " . $conn->error);
    }
} catch (Exception $e) {
    $response['error'] = "Nem sikerült rögzíteni a megrendelést az adatbázisban. Próbálkozz újra később!";
    echo json_encode($response);
    exit();
}
?>
