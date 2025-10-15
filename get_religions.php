<?php
header('Content-Type: application/json');
include 'db_config.php';  // This file should set up $conn (mysqli connection)

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$sql = "SELECT id, religion_id, name, image_url FROM religions";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

$religions = [];

while ($row = $result->fetch_assoc()) {
    $religions[] = [
        'id' => $row['id'],  // Added id
        'religion_id' => $row['religion_id'], // Added religion_id (same as id)
        'name' => $row['name'],
        'image' => "https://jaimee-bevilled-unpoutingly.ngrok-free.dev/divinestay_api/" . $row['image_url']
    ];
}

echo json_encode($religions);
$conn->close();
?>
