<?php
include 'db_config.php';
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['place_id'])) {
    echo json_encode(['error' => 'Missing place_id parameter']);
    exit;
}

$place_id = $_GET['place_id'];
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if (!filter_var($place_id, FILTER_VALIDATE_INT)) {
    echo json_encode(['error' => 'Invalid place_id parameter']);
    exit;
}

if ($user_id !== null && (!filter_var($user_id, FILTER_VALIDATE_INT) || intval($user_id) < 0)) {
    echo json_encode(['error' => 'Invalid user_id parameter']);
    exit;
}

// Assuming hotels table has columns 'distance' and 'duration' as strings (e.g. "300 meters", "3 mins")
// Adjust column types or calculation on backend if needed

if ($user_id !== null) {
    $stmt = $conn->prepare("
        SELECT h.id, h.hotel_name, h.location, h.price_per_night, h.image_url, h.description, h.rating, h.facilities,
               h.distance, h.duration,
               (f.user_id IS NOT NULL) AS is_favorite
        FROM hotels h
        LEFT JOIN favorites f ON h.id = f.hotel_id AND f.user_id = ?
        WHERE h.place_id = ?
    ");
    $stmt->bind_param("ii", $user_id, $place_id);
} else {
    $stmt = $conn->prepare("
        SELECT id, hotel_name, location, price_per_night, image_url, description, rating, facilities, distance, duration, 0 AS is_favorite
        FROM hotels
        WHERE place_id = ?
    ");
    $stmt->bind_param("i", $place_id);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => $row['id'],
            "name" => $row['hotel_name'],
            "location" => $row['location'],
            "price" => $row['price_per_night'],
            "image_url" => "https://jaimee-bevilled-unpoutingly.ngrok-free.dev/divinestay_api/" . $row['image_url'],
            "description" => $row['description'],
            'rating' => number_format(floatval($row['rating']), 1),
            "facilities" => $row['facilities'],
            "distance" => $row['distance'],    // new
            "duration" => $row['duration'],    // new
            "is_favorite" => (bool)$row['is_favorite']
        ];
    }

    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Database query failed']);
}

$stmt->close();
$conn->close();
?>
