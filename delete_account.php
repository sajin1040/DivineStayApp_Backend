<?php
header('Content-Type: application/json');
include 'db_config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
    exit();
}

// Read the raw POST data (JSON)
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON input"
    ]);
    exit();
}

// Extract values safely
$email = isset($data['email']) ? trim($data['email']) : '';
$password = isset($data['password']) ? $data['password'] : '';
$reason = isset($data['reason']) ? trim($data['reason']) : '';

// Validate inputs
if (empty($email) || empty($password)) {
    echo json_encode([
        "success" => false,
        "message" => "Email and password are required"
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
    // Prepare and execute query to find user by email
    $stmt = $conn->prepare("SELECT id, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid email or password"
        ]);
        $stmt->close();
        $conn->close();
        exit();
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    // Verify password
    if (password_verify($password, $user['password'])) {
        $userId = $user['id'];

        // Optionally log deletion reason here by inserting in a separate table or log file if needed

        // Delete user from database
        $deleteStmt = $conn->prepare("DELETE FROM user WHERE id = ?");
        $deleteStmt->bind_param("i", $userId);
        if ($deleteStmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Account deleted successfully"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to delete account"
            ]);
        }
        $deleteStmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid email or password"
        ]);
    }

    $conn->close();

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
?>
