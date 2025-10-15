<?php
$conn = new mysqli("localhost", "root", "", "divinestay_db");

$user_id = 1; // Replace with session-based ID

$query = "SELECT h.*, 
            IF(f.user_id IS NOT NULL, 1, 0) as is_favorite
          FROM hotels h
          LEFT JOIN favorites f ON f.hotel_id = h.id AND f.user_id = $user_id";

$result = $conn->query($query);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
