<?php
header('Content-Type: application/json');
include 'db_config.php';

if (!isset($_GET['user_id']) || !isset($_GET['hotel_id'])) {
    echo json_encode(["error" => "Missing parameter"]); exit;
}

$userId = $_GET['user_id'];
$hotelId = $_GET['hotel_id'];

// Check if already exists
$stmt = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND hotel_id = ?");
$stmt->bind_param("ss", $userId, $hotelId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => "Already favorited"]); exit; // Optional: treat as success
}
$stmt->close();

// Insert new favorite
$stmt = $conn->prepare("INSERT INTO favorites (user_id, hotel_id) VALUES (?, ?)");
$stmt->bind_param("ss", $userId, $hotelId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
