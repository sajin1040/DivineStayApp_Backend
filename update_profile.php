<?php
include 'db_config.php';

if (
    !isset($_GET['user_id']) || !is_numeric($_GET['user_id']) ||
    !isset($_GET['first_name']) || !isset($_GET['last_name']) ||
    !isset($_GET['email']) || !isset($_GET['phone'])
) {
    echo "error";
    exit;
}

$user_id   = intval($_GET['user_id']);
$firstName = trim($_GET['first_name']);
$lastName  = trim($_GET['last_name']);
$email     = trim($_GET['email']);
$phone     = trim($_GET['phone']);

$sql = "UPDATE user SET first_name = ?, last_name = ?, email = ?, phone_number = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $firstName, $lastName, $email, $phone, $user_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
