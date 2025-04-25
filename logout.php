<?php
session_start();

header('Content-Type: application/json');

session_destroy();
setcookie('user_auth', '', time() - 3600, '/');

echo json_encode([
    'success' => true,
    'message' => 'Logged out successfully'
]);
?>