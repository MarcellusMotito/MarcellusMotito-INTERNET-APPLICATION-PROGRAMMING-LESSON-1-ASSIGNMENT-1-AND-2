<?php
require_once 'config.php';

header('Content-Type: application/json');

$data = $_POST;
file_put_contents('login_debug.txt', "POST Data: " . print_r($_POST, true) . "\n", FILE_APPEND);

$email = trim($data['email'] ?? '');
$password = trim($data['password'] ?? '');


if (empty($email) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required'
    ]);
    exit;
}

$email = filter_var($email, FILTER_SANITIZE_EMAIL);

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        setcookie('user_auth', hash('sha256', $user['email']), time() + 86400, '/', '', true, true);
        echo json_encode([
            'success' => true,
            'message' => 'Login successful'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid credentials'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>