<?php
include 'db_config.php';

// Sanitize & validate 'query' parameter
if (!isset($_GET['query']) || empty(trim($_GET['query']))) {
    echo json_encode(['status' => 'error', 'message' => 'Empty search query']);
    exit();
}

$query = "%" . $conn->real_escape_string(trim($_GET['query'])) . "%";

// Combined SQL for hotels and popular places matching name or state
$sql = "
    SELECT id, hotel_name AS name, location, image_url, 'hotel' as type FROM hotels WHERE hotel_name LIKE ?
    UNION
    SELECT id, place_name AS name, state AS location, image_url, 'place' as type FROM popular_places WHERE place_name LIKE ? OR state LIKE ?
    LIMIT 50
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Database prepare failed']);
    exit();
}

// Bind parameters for hotel_name, place_name, and state
$stmt->bind_param("sss", $query, $query, $query);

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    // Make image_url full if needed - add domain if stored as relative path
    if (!filter_var($row['image_url'], FILTER_VALIDATE_URL)) {
        $row['image_url'] = "https://jaimee-bevilled-unpoutingly.ngrok-free.dev/divinestay_api/" . ltrim($row['image_url'], '/');
    }
    $data[] = $row;
}

echo json_encode(['status' => 'success', 'results' => $data]);

$stmt->close();
$conn->close();
