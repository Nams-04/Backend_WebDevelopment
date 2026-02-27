<?php
require_once "db_connection.php";

if (!isset($_POST['name'], $_POST['email'], $_POST['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields required']);
    exit;
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $password]);

    echo json_encode(['message' => 'User created']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Insert failed']);
}
?>