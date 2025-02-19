<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $player_name = $_POST["player_name"];
    $date_played = $_POST["date_played"];

    $stmt = $conn->prepare("INSERT INTO scorecards (player_name, date_played) VALUES (?, ?)");
    $stmt->bind_param("ss", $player_name, $date_played);
    $stmt->execute();

    echo $conn->insert_id;
}
?>
