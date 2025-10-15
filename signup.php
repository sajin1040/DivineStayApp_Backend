<?php
header('Content-Type: application/json');
include 'db_config.php';

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
    exit();
}

// Read raw POST data (JSON string)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Validate JSON decoding
if ($input === null) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON input"
    ]);
    exit();
}

// Extract variables from JSON input safely
$first_name   = isset($input['first_name']) ? trim($input['first_name']) : '';
$last_name    = isset($input['last_name']) ? trim($input['last_name']) : '';
$email        = isset($input['email']) ? trim($input['email']) : '';
$phone_number = isset($input['phone_number']) ? trim($input['phone_number']) : '';
$password     = isset($input['password']) ? $input['password'] : '';

// Validate inputs
if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_number) || empty($password)) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email format"
    ]);
    exit();
}

try {
    // Check if email already exists - adjust table name if needed
    $checkStmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult && $checkResult->num_rows > 0) {
        echo json_encode([
            "success" => false,
            "message" => "Email already exists"
        ]);
        $checkStmt->close();
        $conn->close();
        exit();
    }
    $checkStmt->close();

    // Hash password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into database
    $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, phone_number, password, timestamp) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone_number, $hashed_password);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id;
        echo json_encode([
            "success" => true,
            "message" => "Registration successful",
            "user" => [
                "id"           => $user_id,
                "first_name"   => $first_name,
                "last_name"    => $last_name,
                "email"        => $email,
                "phone_number" => $phone_number
            ]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Registration failed. Please try again."
        ]);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
