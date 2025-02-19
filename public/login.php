<?php
session_start(); 
require_once('../includes/db.php');

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php"); 
    exit();
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Find the user in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // Check if the user exists and the password is correct
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit(); 
    } else {
        $error_message = "No user found with that username or incorrect password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeeBot - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-blue-500 to-green-500">

    <div class="flex justify-center items-center h-screen">
        <div class="w-full max-w-md">
            <form action="" method="POST" class="bg-white shadow-lg rounded-lg px-8 pt-10 pb-8 mb-4">
                <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Welcome to TeeBot</h2>

                <!-- Error message display -->
                <?php
                if (isset($error_message)) {
                    echo "<p class='text-red-500 text-sm text-center mb-4'>$error_message</p>";
                }
                ?>

                <div class="mb-6">
                    <label for="username" class="block text-lg font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex flex-col items-center">
                    <button type="submit" class="bg-gradient-to-r from-green-500 to-blue-500 text-white py-3 px-6 rounded-lg shadow-md hover:bg-gradient-to-r hover:from-green-600 hover:to-blue-600 transition-all duration-300 w-full mb-4">Login</button>
                    <a href="signup.php" class="text-blue-500 text-sm">Don't have an account? Sign Up</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="login.js"></script>
</body>
</html>
