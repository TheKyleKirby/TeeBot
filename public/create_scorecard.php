<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: TeeBot/public/login.php");
    exit();
}

require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];
    $hole_scores = [];

    for ($i = 1; $i <= 18; $i++) {
        $hole_scores["hole_$i"] = $_POST["hole_$i"];
    }
    // Insert the scorecard data into database
    $stmt = $pdo->prepare("INSERT INTO scorecards (username, course_name, " . implode(",", array_keys($hole_scores)) . ") VALUES (:username, :course_name, " . implode(",", array_fill(0, 18, '?')) . ")");
    $stmt->execute(array_merge(['username' => $_SESSION['username'], 'course_name' => $course_name], array_values($hole_scores)));

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Golf Scorecard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-green-400 to-blue-500 h-screen flex justify-center items-center">

    <div class="p-8 bg-white shadow-xl rounded-xl max-w-4xl w-full">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Golf Scorecard</h1>
        <!-- Create Scorecard Form -->
        <form method="POST" action="../private/save_scorecard.php">
            <div class="mb-6">
                <label for="course_name" class="block text-lg font-medium text-gray-700">Course Name</label>
                <input type="text" id="course_name" name="course_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <div class="overflow-x-auto mb-6">
                <table class="min-w-full text-center border-collapse">
                    <thead>
                        <tr class="bg-green-100">
                            <th class="px-4 py-2 text-lg font-semibold text-gray-700">Hole</th>
                            <?php for ($i = 1; $i <= 18; $i++) : ?>
                                <th class="px-4 py-2 text-lg font-semibold text-gray-700"><?php echo $i; ?></th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 font-semibold text-gray-700">Score</td>
                            <?php for ($i = 1; $i <= 18; $i++) : ?>
                                <td><input type="number" name="hole_<?php echo $i; ?>" class="w-16 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required></td>
                            <?php endfor; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-6 text-center">
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3 rounded-lg shadow-md hover:bg-gradient-to-r hover:from-blue-600 hover:to-blue-700 transition duration-300">Save Scorecard</button>
            </div>
        </form>
    </div>

</body>
</html>
