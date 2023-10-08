<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pizzaType = $_POST['pizzaType'];
    $pizzaSize = $_POST['pizzaSize'];
    $extraCheese = isset($_POST['extraCheese']) && $_POST['extraCheese'] === '1' ? 1 : 0;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $checkOrderSql = "SELECT * FROM pizza WHERE email = ? AND ido >= NOW() - INTERVAL 1 MINUTE";
    $stmt = $conn->prepare($checkOrderSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['error'] = 'Egy e-mail-címről percenként legfeljebb egy megrendelést lehet leadni!';
    } elseif (empty($name)) {
        $response['error'] = 'Meg kell adni a nevet is!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error'] = 'Érvénytelen e-mail formátum!';
    } elseif (!preg_match("/^[0-9+]+$/", $phone)) {
        $response['error'] = 'Érvénytelen telefonszám!';
    } else {
        $insertSql = $conn->prepare("INSERT INTO pizza (nev, email, telefon, pizza, meret, extrasajt, ido) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
        $pizzaSizeValue = (string)$pizzaSize;
        $insertSql->bind_param("ssssss", $name, $email, $phone, $pizzaType, $pizzaSizeValue, $extraCheese);

        if ($insertSql->execute()) {
            $orderId = $insertSql->insert_id;
            $response['success'] = true;
            $response['message'] = "Megrendelés sikeresen rögzítve!";
            $response['orderId'] = $orderId;
        } else {
            $response['error'] = "Error: " . $conn->error;
        }

        $insertSql->close();
    }

    $stmt->close();
    echo json_encode($response);
}
?>