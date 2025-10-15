<?php
include 'db_config.php';

header('Content-Type: application/json');

// Can identify user by email or ID (whichever you store in SessionManager)
if (!isset($_GET['email']) && !isset($_GET['user_id'])) {
    echo json_encode(["success" => false, "message" => "Missing parameter"]);
    exit;
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, phone_number, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
} else {
    $user_id = intval($_GET['user_id']);
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, phone_number, password FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "success" => true,
        "data" => $row
    ]);
} else {
    echo json_encode(["success" => false, "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
