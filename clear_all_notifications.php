<?php
header('Content-Type: application/json');
include 'db_config.php';

if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing user_id']);
    exit();
}

$user_id = intval($_POST['user_id']);

$stmt = $conn->prepare("DELETE FROM notifications WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to clear notifications']);
}

$stmt->close();
$conn->close();
?>
