<?php
require_once "db_connection.php";

// Read JSON input (for PUT)
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'], $data['name'], $data['email'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing data']);
    exit;
}

$user_id = $data['user_id'];
$name = $data['name'];
$email = $data['email'];

try {
    // Update user
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $user_id]);

    // Fetch updated user
    $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user) {
        echo json_encode([
            'message' => 'User updated',
            'user' => $user
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Update failed']);
}
?>