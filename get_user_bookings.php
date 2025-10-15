<?php
include 'db_config.php';

$user_id = intval($_GET['user_id']);

// ✅ Added b.total_price
$sql = "SELECT 
            b.id AS booking_id,
            b.hotel_name,
            h.location,
            -- format rating to max 1 decimal, remove trailing .0
            TRIM(TRAILING '.' FROM TRIM(TRAILING '0' FROM FORMAT(h.rating,1))) AS rating,
            h.price_per_night,
            b.total_price,  -- ✅ new column
            b.hotel_image AS image_url,
            b.checkin_date,
            b.checkout_date,
            CONCAT(b.adults + b.children, ' Guests') AS guests,
            h.latitude,
            h.longitude
        FROM bookings b
        JOIN hotels h ON b.hotel_id = h.id
        WHERE b.user_id = $user_id
        ORDER BY b.created_at DESC";

$result = $conn->query($sql);

$bookings = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($bookings);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
