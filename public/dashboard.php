<?php
session_start(); // Start the session

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: TeeBot/public/login.php");
    exit();
}

require_once '../includes/db.php'; // Ensure correct path for db connection

// Fetch scorecards for the logged-in user from the database
$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT * FROM scorecards WHERE username = :username ORDER BY created_at DESC");
$stmt->execute(['username' => $username]);
$scorecards = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TeeBot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-r from-green-400 to-blue-500">
    <!-- Navbar -->
    <nav class="bg-transparent p-6">
        <div class="container mx-auto flex justify-between items-center">
            <a href="dashboard.php" class="text-white text-3xl font-extrabold tracking-wide hover:text-green-300 transition duration-300">TeeBot</a>
            <ul class="flex space-x-8">
                <li><a href="dashboard.php" class="text-white text-lg hover:text-gray-200 transition duration-200">Dashboard</a></li>
                <li><a href="create_scorecard.php" class="text-white text-lg hover:text-gray-200 transition duration-200">Create Scorecard</a></li>
                <li><a href="/TeeBot/private/logout.php" class="text-white text-lg hover:text-gray-200 transition duration-200">Logout</a></li>
            </ul>
        </div>
    </nav>
    <!-- Main Dashboard -->
    <div class="container mx-auto p-8 bg-white shadow-2xl rounded-lg mt-10">
        <h1 class="text-4xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p class="mt-4 text-xl text-gray-600">Ready to track your golf scores? Let's get started!</p>
        <!-- Create Scorecard Button -->
        <div class="mt-6">
            <a href="create_scorecard.php" class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-8 py-4 rounded-full shadow-xl hover:from-green-600 hover:to-blue-600 transition-all duration-300 ease-in-out">Create Scorecard</a>
        </div>
        <div class="mt-10">
            <h2 class="text-2xl font-semibold text-gray-800">Recent Scorecards</h2>

            <?php if (count($scorecards) > 0) : ?>
                <div class="mt-6 space-y-6">
                    <?php foreach ($scorecards as $scorecard) : ?>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                            <p class="text-lg font-medium text-gray-700">Scorecard for Course: <strong class="text-green-600"><?php echo htmlspecialchars($scorecard['course_name']); ?></strong></p>
                            <p class="text-sm text-gray-500">Date Played: <?php echo date("m/d/Y", strtotime($scorecard['created_at'])); ?></p>
                            <a href="view_scorecard.php?id=<?php echo $scorecard['id']; ?>" class="inline-block mt-3 text-blue-500 hover:text-blue-700">View Scorecard</a>
                            <button onclick="confirmDelete(<?php echo $scorecard['id']; ?>)" class="inline-block mt-3 ml-4 text-red-500 hover:text-red-700">Delete Scorecard</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="text-gray-500">You haven't created any scorecards yet. Create one to start tracking your scores!</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Deletion Modal -->
    <script>
        function confirmDelete(scorecardId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the scorecard permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete_scorecard.php?id=' + scorecardId;
                }
            });
        }
    </script>

</body>
</html>
