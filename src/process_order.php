<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('db_connect.php'); // Include the database connection file

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pizzaType = $_POST['pizzaType'];
    $pizzaSize = $_POST['pizzaSize'];
    $extraCheese = isset($_POST['extraCheese']) && $_POST['extraCheese'] === '1' ? 1 : 0;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (empty($name)) {
        echo "Error: Name is required!";
        $response['nameError'] = true;
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email format!";
        $response['emailError'] = true;
        return;
    }

    if (!preg_match("/^[0-9+]+$/", $phone)) {
        echo "Error: Invalid phone number!";
        $response['phoneError'] = true;
        return;
    }

    $insertSql = "INSERT INTO pizza (nev, email, telefon, pizza, meret, extrasajt, ido)
                  VALUES ('$name', '$email', '$phone', '$pizzaType', '$pizzaSize', '$extraCheese', CURRENT_TIMESTAMP)";

    if ($conn->query($insertSql) === TRUE) {
        echo "Order submitted successfully!";
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}

echo json_encode($response);
?>