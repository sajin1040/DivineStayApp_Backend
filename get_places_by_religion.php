<?php
header('Content-Type: application/json');
include 'db_config.php';

if (!isset($_GET['religion_id'])) {
    echo json_encode([]);
    exit;
}

$religion_id = $_GET['religion_id'];

// Sanitize input (optional but recommended)
$religion_id = mysqli_real_escape_string($conn, $religion_id);

$query = "SELECT id, religion_id, place_name, state, image_url FROM destinations WHERE religion_id = '$religion_id'";

$result = mysqli_query($conn, $query);

$places = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Prepend base URL path to image url if images are stored inside divinestay_api/images/
        $row['image_url'] = "https://jaimee-bevilled-unpoutingly.ngrok-free.dev/divinestay_api/" . $row['image_url'];
        $places[] = $row;
    }
    mysqli_free_result($result);
}

mysqli_close($conn);

echo json_encode($places);
?>
