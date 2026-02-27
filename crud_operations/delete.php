<?php
require_once "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'])) {
    echo json_encode(['error' => 'user_id required']);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$data['user_id']]);

echo json_encode(['message' => 'User deleted']);
?>