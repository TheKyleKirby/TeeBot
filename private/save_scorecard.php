<?php
session_start();
require_once '../includes/db.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

if (empty($_POST['course_name'])) {
    die("Error: Course name is required.");
}

$course_name = trim($_POST['course_name']);
$username = $_SESSION['username'];
$scorecard_id = isset($_POST['scorecard_id']) ? (int) $_POST['scorecard_id'] : null;

$scores = [];
for ($i = 1; $i <= 18; $i++) {
    $hole_key = "hole_$i";
    if (!isset($_POST[$hole_key]) || !is_numeric($_POST[$hole_key])) {
        die("Error: Invalid score for hole $i.");
    }
    $scores[$hole_key] = (int) $_POST[$hole_key]; 
}

if ($scorecard_id) {
    $query = "UPDATE scorecards 
              SET course_name = :course_name, 
                  hole_1 = :hole_1, hole_2 = :hole_2, hole_3 = :hole_3, hole_4 = :hole_4, 
                  hole_5 = :hole_5, hole_6 = :hole_6, hole_7 = :hole_7, hole_8 = :hole_8, 
                  hole_9 = :hole_9, hole_10 = :hole_10, hole_11 = :hole_11, hole_12 = :hole_12, 
                  hole_13 = :hole_13, hole_14 = :hole_14, hole_15 = :hole_15, hole_16 = :hole_16, 
                  hole_17 = :hole_17, hole_18 = :hole_18 
              WHERE id = :id AND username = :username";
    $stmt = $pdo->prepare($query);
    $scores[':id'] = $scorecard_id; 
} else {
    $query = "INSERT INTO scorecards (username, course_name, hole_1, hole_2, hole_3, hole_4, 
              hole_5, hole_6, hole_7, hole_8, hole_9, hole_10, hole_11, hole_12, hole_13, 
              hole_14, hole_15, hole_16, hole_17, hole_18) 
              VALUES (:username, :course_name, :hole_1, :hole_2, :hole_3, :hole_4, :hole_5, 
                      :hole_6, :hole_7, :hole_8, :hole_9, :hole_10, :hole_11, :hole_12, 
                      :hole_13, :hole_14, :hole_15, :hole_16, :hole_17, :hole_18)";
    $stmt = $pdo->prepare($query);
}

try {
    $stmt->execute(array_merge([':username' => $username, ':course_name' => $course_name], $scores));

    header("Location: ../public/dashboard.php");
    exit();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
