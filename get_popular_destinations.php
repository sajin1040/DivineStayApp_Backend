<?php
header('Content-Type: application/json');
include 'db_config.php';  // mysqli $conn connection

$baseUrl = "https://jaimee-bevilled-unpoutingly.ngrok-free.dev/divinestay_api/";

$sql = "SELECT id, place_name, state, image_url FROM popular_places";

if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();

    $destinations = [];

    while ($row = $result->fetch_assoc()) {
        $destinations[] = [
            "id"        => $row['id'],                   // ✅ Include place_id
            "title"     => $row['place_name'],
            "location"  => $row['state'],
            "image_url" => $baseUrl . $row['image_url']
        ];
    }

    echo json_encode($destinations);
    $stmt->close();
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to prepare statement"]);
}
$conn->close();
