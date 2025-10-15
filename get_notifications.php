<?php
header('Content-Type: application/json; charset=utf-8');
include 'db_config.php';

// Validate user_id parameter
if (!isset($_GET['user_id']) || !filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or invalid user_id parameter']);
    exit();
}

$user_id = (int)$_GET['user_id'];

// Prepare SQL to fetch notifications for the user ordered by newest first
$sql = "SELECT id, user_id, message, type, created_at 
        FROM notifications 
        WHERE user_id = ? 
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to prepare statement']);
    exit();
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to execute query']);
    exit();
}

$result = $stmt->get_result();
$notifications = [];

while ($row = $result->fetch_assoc()) {
    // Generate title based on type
    switch ($row['type']) {
        case 'booking_update':
            $row['title'] = 'Booking Update';
            break;
        case 'promotion':
            $row['title'] = 'Promotion';
            break;
        default:
            $row['title'] = 'Notification';
    }
    $notifications[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($notifications);
