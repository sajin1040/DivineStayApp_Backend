<?php
include 'db_config.php';

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Missing hotel id"]);
    exit;
}

$hotel_id = $_GET['id'];

// Prepare statement including latitude and longitude
$stmt = $conn->prepare(
    "SELECT id, hotel_name, location, rating, price_per_night, image_url, description, facilities, latitude, longitude
     FROM hotels WHERE id = ?"
);
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$stmt->bind_result($id, $hotel_name, $location, $rating, $price_per_night, $image_url, $description, $facilities, $latitude, $longitude);

if ($stmt->fetch()) {
    // Format rating to one decimal place, remove trailing zeros if any
    $formatted_rating = rtrim(rtrim(number_format((float)$rating, 1), '0'), '.');

    echo json_encode([
        "id" => $id,
        "name" => $hotel_name,
        "location" => $location,
        "rating" => $formatted_rating,
        "price" => $price_per_night,
        "image_url" => "https://jaimee-bevilled-unpoutingly.ngrok-free.dev/divinestay_api/" . $image_url,
        "description" => $description,
        "facilities" => $facilities,
        "latitude" => $latitude,
        "longitude" => $longitude
    ]);
} else {
    echo json_encode(["error" => "No hotel found"]);
}

$stmt->close();
$conn->close();
