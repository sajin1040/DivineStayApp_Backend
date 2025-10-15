<?php
include 'db_config.php';

error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

// List of required POST parameters
$required = [
    'user_email', 'user_phone', 'hotel_id', 'hotel_name', 'hotel_image',
    'check_in', 'check_out', 'adults', 'children',
    'room_type', 'total_price', 'platform_fee', 'nights'
];

// Validate presence of required fields
foreach ($required as $param) {
    if (!isset($_POST[$param])) {
        echo json_encode([
            "success" => false,
            "message" => "Missing parameter: $param"
        ]);
        exit;
    }
}

// Sanitize & assign variables
$user_email   = mysqli_real_escape_string($conn, $_POST['user_email']);
$user_phone   = mysqli_real_escape_string($conn, $_POST['user_phone']); 
$hotel_id     = (int) $_POST['hotel_id'];
$hotel_name   = mysqli_real_escape_string($conn, $_POST['hotel_name']);
$hotel_image  = mysqli_real_escape_string($conn, $_POST['hotel_image']);
$check_in     = mysqli_real_escape_string($conn, $_POST['check_in']);
$check_out    = mysqli_real_escape_string($conn, $_POST['check_out']);
$adults       = (int) $_POST['adults'];
$children     = (int) $_POST['children'];
$room_type    = mysqli_real_escape_string($conn, $_POST['room_type']);
$total_price  = (float) $_POST['total_price'];
$platform_fee = (float) $_POST['platform_fee'];
$nights       = (int) $_POST['nights'];

// Get user_id from users table using email
$sql_user = "SELECT id FROM user WHERE email = '$user_email' LIMIT 1";
$res_user = $conn->query($sql_user);

if ($res_user->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}
$user_data = $res_user->fetch_assoc();
$user_id = (int)$user_data['id'];

// Optionally update user's phone number in `user` table (using phone_number column)
$update_phone_sql = "UPDATE user SET phone_number = '$user_phone' WHERE id = $user_id";
$conn->query($update_phone_sql);

// Insert booking into bookings table (also storing phone_number if you want it there too)
$sql_booking = "INSERT INTO bookings 
(user_id, hotel_id, hotel_name, hotel_image, checkin_date, checkout_date, adults, children, room_type, total_price, platform_fee, nights, phone_number)
VALUES 
($user_id, $hotel_id, '$hotel_name', '$hotel_image', '$check_in', '$check_out', $adults, $children, '$room_type', $total_price, $platform_fee, $nights, '$user_phone')";

if ($conn->query($sql_booking)) {

    // Insert booking notification
    $message = "Your booking for '$hotel_name' is confirmed.";
    $message = mysqli_real_escape_string($conn, $message);

    $sql_notify = "INSERT INTO notifications (user_id, message, type, created_at)
                   VALUES ($user_id, '$message', 'booking', NOW())";
    $conn->query($sql_notify);

    echo json_encode([
        "success" => true,
        "message" => "Booking confirmed and notification added"
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Booking failed: " . $conn->error
    ]);
}

$conn->close();