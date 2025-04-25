<?php
require_once 'config.php';

header('Content-Type: application/json');


$data = $_POST;
file_put_contents('debug.txt', print_r($data, true));
$fullname = trim($data['fullname'] ?? '');
$email = trim($data['email'] ?? '');
$password = trim($data['password'] ?? '');
$confirm_password = trim($data['confirm_password'] ?? '');


if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required'
    ]);
    exit;
}


if ($password !== $confirm_password) {
    echo json_encode([
        'success' => false,
        'message' => 'Passwords do not match'
    ]);
    exit;
}


$email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid email format'
    ]);
    exit;
}


$fullname = htmlspecialchars($fullname);


$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Email already exists'
        ]);
        exit;
    }

    
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute([
        'name' => $fullname,
        'email' => $email,
        'password' => $password_hash
    ]);

    
    $_SESSION['user_id'] = $pdo->lastInsertId();
    setcookie('user_auth', hash('sha256', $email), time() + 86400, '/', '', true, true);

    echo json_encode([
        'success' => true,
        'message' => 'Registration successful'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>