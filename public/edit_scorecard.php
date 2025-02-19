<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

require_once 'db.php';

if (!isset($_GET['id'])) {
    die("No scorecard selected.");
}

$scorecard_id = $_GET['id'];
// Fetch the scorecard from the database
$stmt = $pdo->prepare("SELECT * FROM scorecards WHERE id = :id AND username = :username");
$stmt->execute(['id' => $scorecard_id, 'username' => $_SESSION['username']]);
$scorecard = $stmt->fetch();
if (!$scorecard) {
    die("Scorecard not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $scores = [];
    for ($i = 1; $i <= 18; $i++) {
        $scores["hole_$i"] = $_POST["hole_$i"];
    }
    // Update the scorecard in the database
    try {
        $stmt = $pdo->prepare("UPDATE scorecards SET course_name = :course_name, hole_1 = :hole_1, hole_2 = :hole_2, hole_3 = :hole_3, hole_4 = :hole_4, hole_5 = :hole_5, hole_6 = :hole_6, hole_7 = :hole_7, hole_8 = :hole_8, hole_9 = :hole_9, hole_10 = :hole_10, hole_11 = :hole_11, hole_12 = :hole_12, hole_13 = :hole_13, hole_14 = :hole_14, hole_15 = :hole_15, hole_16 = :hole_16, hole_17 = :hole_17, hole_18 = :hole_18 WHERE id = :id AND username = :username");

        $stmt->execute(array_merge([':username' => $_SESSION['username'], ':course_name' => $course_name, ':id' => $scorecard_id], $scores));
        // After updating, redirect to the view page
        header("Location: view_scorecard.php?id=$scorecard_id");
        exit(); 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<h1>Edit Scorecard for <?php echo htmlspecialchars($scorecard['course_name']); ?></h1>

<form method="POST">
    <div class="mb-4">
        <label for="course_name" class="block text-lg font-medium text-gray-700">Course Name</label>
        <input type="text" id="course_name" name="course_name" class="w-full px-4 py-2 border rounded-md" value="<?php echo htmlspecialchars($scorecard['course_name']); ?>" required>
    </div>

    <!-- Scorecard Table -->
    <table class="w-full text-center border-collapse">
        <thead>
            <tr>
                <th class="px-4 py-2">Hole</th>
                <?php for ($i = 1; $i <= 18; $i++) : ?>
                    <th class="px-4 py-2"><?php echo $i; ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2 font-semibold">Score</td>
                <?php for ($i = 1; $i <= 18; $i++) : ?>
                    <td><input type="number" name="hole_<?php echo $i; ?>" class="w-16 px-2 py-1 border rounded-md" value="<?php echo $scorecard["hole_$i"]; ?>" required></td>
                <?php endfor; ?>
            </tr>
        </tbody>
    </table>

    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md mt-4">Save Changes</button>
</form>
