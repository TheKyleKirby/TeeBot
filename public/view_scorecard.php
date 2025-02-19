<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    header("Location: TeeBot/public/login.php");
    exit();
}

require_once '../includes/db.php'; 

if (isset($_GET['id'])) {
    $scorecard_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM scorecards WHERE id = :id");
    $stmt->execute(['id' => $scorecard_id]);
    $scorecard = $stmt->fetch();
    // Check if the scorecard exists
    if (!$scorecard) {
        die("Scorecard not found.");
    }
} else {
    die("No scorecard ID provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Golf Scorecard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-green-400 to-blue-500 h-screen flex justify-center items-center">

    <div class="container mx-auto p-8 bg-white shadow-xl rounded-lg max-w-4xl w-full">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Golf Scorecard</h1>
        <!-- Course Name and Date -->
        <div class="mb-8">
            <h2 class="text-xl font-medium text-gray-700">Course: <span class="text-green-600"><?php echo htmlspecialchars($scorecard['course_name']); ?></span></h2>
            <p class="text-gray-500">Date Played: <?php echo date("m/d/Y", strtotime($scorecard['created_at'])); ?></p>
        </div>
        <!-- Scorecard Table -->
        <form method="POST" action="../private/update_scorecard.php">
            <input type="hidden" name="scorecard_id" value="<?php echo $scorecard['id']; ?>">

            <div class="overflow-x-auto mb-8">
                <table class="min-w-full text-center border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-gray-600">Hole</th>
                            <?php for ($i = 1; $i <= 18; $i++) : ?>
                                <th class="px-4 py-2 text-gray-600"><?php echo $i; ?></th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 font-semibold text-gray-700">Score</td>
                            <?php for ($i = 1; $i <= 18; $i++) : ?>
                                <td>
                                    <input type="number" name="hole_<?php echo $i; ?>" value="<?php echo htmlspecialchars($scorecard["hole_$i"]); ?>" class="w-16 px-2 py-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Save Changes Button -->
            <div class="mt-6 text-center">
                <button type="submit" class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-8 py-4 rounded-full shadow-lg hover:from-green-600 hover:to-blue-600 transition-all duration-300 ease-in-out">Save Changes</button>
            </div>
        </form>
    </div>

</body>
</html>
