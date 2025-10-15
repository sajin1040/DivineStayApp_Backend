<?php
include 'db_config.php';

$booking_id = intval($_GET['booking_id']);

if ($booking_id > 0) {
    $sql = "DELETE FROM bookings WHERE id = $booking_id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Booking cancelled successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error cancelling booking: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid booking ID."]);
}

$conn->close();
?>
