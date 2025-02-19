<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: TeeBot/public/login.php");
    exit();
}

require_once '../includes/db.php';

if (isset($_GET['id'])) {
    $scorecard_id = $_GET['id'];
    // Delete the scorecard from the database
    $stmt = $pdo->prepare("DELETE FROM scorecards WHERE id = :id AND username = :username");
    $stmt->execute(['id' => $scorecard_id, 'username' => $_SESSION['username']]);

    header("Location: dashboard.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>
