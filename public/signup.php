<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "teebot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    // Password check
    if ($pass !== $confirmPassword) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if username already exists
        $sql = "SELECT * FROM users WHERE username='$user'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $error_message = "Username already exists.";
        } else {
            $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
            if ($conn->query($sql) === TRUE) {
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeeBot - Sign Up</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-purple-500 to-indigo-600">

    <div class="flex justify-center items-center h-screen">
        <div class="w-full max-w-md">
            <form action="signup.php" method="POST" class="bg-white shadow-lg rounded-lg px-8 pt-10 pb-8 mb-4">
                <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">TeeBot Sign Up</h2>

                <?php
                if (isset($error_message)) {
                    echo "<p class='text-red-500 text-sm text-center mb-4'>$error_message</p>";
                }
                ?>
                <div class="mb-6">
                    <label for="username" class="block text-lg font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                </div>
                <div class="mb-6">
                    <label for="confirmPassword" class="block text-lg font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                </div>
                <div class="flex flex-col items-center">
                    <button type="submit" class="bg-gradient-to-r from-blue-500 to-green-500 text-white py-3 px-6 rounded-lg shadow-md hover:bg-gradient-to-r hover:from-blue-600 hover:to-green-600 transition-all duration-300 w-full mb-4">Sign Up</button>
                    <a href="login.php" class="text-blue-500 text-sm">Already have an account? Login</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="signup.js"></script>
</body>
</html>
