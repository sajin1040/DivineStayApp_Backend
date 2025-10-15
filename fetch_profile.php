<?php
include 'db_config.php';

if (!isset($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
    echo json_encode(['error' => 'Invalid user id']);
    exit;
}

$user_id = intval($_GET['user_id']);

$sql = "SELECT first_name, last_name, email, phone_number FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'Database error']);
}

$stmt->close();
$conn->close();
?>
