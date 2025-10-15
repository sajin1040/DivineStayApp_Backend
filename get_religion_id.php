<?php
include 'db_config.php';

if (!isset($_GET['name'])) {
    echo json_encode([]);
    exit;
}

$name = $_GET['name'];

$stmt = $conn->prepare("SELECT id FROM religions WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($row = $result->fetch_assoc()) {
    $data[] = ['id' => $row['id']];
}

echo json_encode($data);
?>
