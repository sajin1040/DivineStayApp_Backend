<?php
header('Content-Type: application/json');
include 'db_config.php';

if (!isset($_GET['user_id']) || !isset($_GET['hotel_id'])) {
    echo json_encode(["error" => "Missing parameter"]); exit;
}

$userId = $_GET['user_id'];
$hotelId = $_GET['hotel_id'];

$stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND hotel_id = ?");
$stmt->bind_param("ss", $userId, $hotelId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
