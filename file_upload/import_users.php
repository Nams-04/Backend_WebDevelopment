<?php
$dsn = 'mysql:host=localhost;dbname=csci6040_study';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Open CSV
$file = fopen(__DIR__ . '/data.csv', 'r');
fgetcsv($file); // skip header row

while (($row = fgetcsv($file)) !== false) {
    [$name, $email, $password] = $row;

    $hashed = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hashed]);
}

fclose($file);
echo "Users imported successfully!";