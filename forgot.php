<?php
require_once 'config.php';

header('Content-Type: application/json');


$data = $_POST;
$email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);

if (empty($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'Email is required'
    ]);
    exit;
}

try {
    
    $stmt = $pdo->prepare("SELECT id, name FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        
        $resetToken = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        
        $stmt = $pdo->prepare("UPDATE users SET reset_token = :token, token_expiry = :expiry WHERE email = :email");
        $stmt->execute([
            'token' => $resetToken,
            'expiry' => $expiry,
            'email' => $email
        ]);

       

        echo json_encode([
            'success' => true,
            'message' => 'Password reset instructions have been sent to your email'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No account found with this email'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to generate reset token: ' . $e->getMessage()
    ]);
}