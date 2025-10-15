<?php
$conn = new mysqli("localhost", "root", "", "divinestay_db");

$user_id = $_POST['user_id'];
$hotel_id = $_POST['hotel_id'];

$check = $conn->query("SELECT * FROM favorites WHERE user_id = '$user_id' AND hotel_id = '$hotel_id'");

if ($check->num_rows > 0) {
    $conn->query("DELETE FROM favorites WHERE user_id = '$user_id' AND hotel_id = '$hotel_id'");
    echo "1";
} else {
    $conn->query("INSERT INTO favorites (user_id, hotel_id) VALUES ('$user_id', '$hotel_id')");
    echo "1";
}
?>
