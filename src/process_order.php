<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

echo 'hi';


include('db_connect.php'); // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pizzaType = $_POST['pizzaType'];
    $pizzaSize = $_POST['pizzaSize'];
    $extraCheese = isset($_POST['extraCheese']) ? $_POST['extraCheese'] : 'No';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    echo $pizzaType;
    echo $pizzaSize;
    echo $extraCheese;
    echo $name;
    echo $email;
    echo $phone;

    // Validate and sanitize the data if needed

    $insertSql = "INSERT INTO pizza (nev, email, telefon, pizza, meret, extrasajt, ido)
                  VALUES ('$name', '$email', '$phone', '$pizzaType', '$pizzaSize', '$extraCheese', CURRENT_TIMESTAMP)";

    if ($conn->query($insertSql) === TRUE) {
        echo "Order submitted successfully!";
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}

?>