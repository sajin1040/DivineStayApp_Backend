<?php
header('Content-Type: application/json; charset=utf-8');
include 'db_config.php';  // mysqli connection setup

// Validate user_id parameter
if (!isset($_GET['user_id']) || !filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or invalid user_id parameter']);
    exit();
}

$user_id = (int)$_GET['user_id'];

// Prepare SQL to fetch favorite hotels for the user, adding rating, distance and duration
$sql = "SELECT 
            h.id, 
            h.hotel_name AS name, 
            h.location, 
            h.price_per_night AS price, 
            h.image_url, 
            h.description, 
            h.facilities,
            h.rating,
            h.distance,
            h.duration
        FROM favorites f
        INNER JOIN hotels h ON f.hotel_id = h.id
        WHERE f.user_id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to execute query']);
        exit();
    }

    $result = $stmt->get_result();
    $favorites = [];

    $baseUrl = "https://jaimee-bevilled-unpoutingly.ngrok-free.dev/divinestay_api/";

    while ($row = $result->fetch_assoc()) {
        // Append is_favourite true to all returned favorites
        $row['is_favourite'] = true;

        // Prepend full base URL to image_url if needed
        if (isset($row['image_url']) && $row['image_url'] && strpos($row['image_url'], 'http') !== 0) {
            $row['image_url'] = $baseUrl . $row['image_url'];
        }

        // Format rating to one decimal place, remove trailing zeros
        $row['rating'] = isset($row['rating']) ? rtrim(rtrim(number_format((float)$row['rating'], 1), '0'), '.') : null;

        // If distance or duration are null or empty, assign a placeholder like "--"
        $row['distance'] = !empty($row['distance']) ? $row['distance'] : "--";
        $row['duration'] = !empty($row['duration']) ? $row['duration'] : "--";

        $favorites[] = $row;
    }

    echo json_encode($favorites);

    $stmt->close();
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to prepare SQL statement']);
}

$conn->close();
