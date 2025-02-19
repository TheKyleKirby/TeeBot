<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: TeeBot/public/login.php");
    exit();
}

require_once '../includes/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $scorecard_id = $_POST['scorecard_id'];

    $hole_scores = [];
    for ($i = 1; $i <= 18; $i++) {
        $hole_scores["hole_$i"] = $_POST["hole_$i"];
    }
     // Prep SQL query to update the scorecard
    $updateQuery = "UPDATE scorecards SET ";
    foreach ($hole_scores as $column => $score) {
        $updateQuery .= "$column = :$column, ";
    }
    $updateQuery = rtrim($updateQuery, ", ") . " WHERE id = :id";

    $stmt = $pdo->prepare($updateQuery);
    $params = ['id' => $scorecard_id] + $hole_scores;
    $stmt->execute($params);

    header("Location: ../public/dashboard.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>
