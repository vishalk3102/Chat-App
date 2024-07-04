<?php
// Set session timeout (e.g., 30 minutes)
$session_timeout = 60; // 30 minutes in seconds

// Set session cookie lifetime
session_set_cookie_params($session_timeout);
if (isset($_COOKIE["user_id"])) {
    $cookieValue = $_COOKIE["user_id"];
}

session_start();

// $_SESSION['last_activity'] = time();
// echo $_SESSION['last_activity'];
// Function to check if session is active
function isSessionActive() {
    return isset($_SESSION['user_data']) && !empty($_SESSION['user_data']);
}

// Function to update last activity timestamp based on client's last activity time
function updateLastActivity($clientLastActivityTime) {
    setcookie("user_id",$clientLastActivityTime,time()+600); // Convert JavaScript timestamp to PHP timestamp
}

// Function to check if session is expired
function isSessionExpired($session_timeout) {
    if (!isset($_COOKIE["user_id"])) {
        return true;
    }
    return false;
}

// Set session timeout (in seconds)
// $session_timeout = 60; // 30 minutes

// Handle AJAX request to check session status
if (isset($_POST['action']) && $_POST['action'] == 'check_session') {
    header('Content-Type: application/json');
    
    if (isSessionActive() && !isSessionExpired($session_timeout)) {
        echo json_encode(['valid' => true]);
    } else {
        echo json_encode(['valid' => false]);
    }
    exit;
}

// Handle AJAX request to update last activity
if (isset($_POST['action']) && $_POST['action'] == 'update_activity') {
    header('Content-Type: application/json');
    
    if (isSessionActive()) {
        $clientLastActivityTime = $_POST['last_activity']; // Get client's last activity time from AJAX request
        updateLastActivity($clientLastActivityTime);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Session not active']);
    }
    exit;
}
?>