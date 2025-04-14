<?php
include('connect.php');
session_start();

if (isset($_POST['submit'])) {
    $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $studentID = filter_input(INPUT_POST, 'student-id', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST["password"];
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $department = filter_input(INPUT_POST, 'department', FILTER_SANITIZE_STRING);

    // Check if username already exists
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM register WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $usernameCount = $row['count'];
    $stmt->close();

    if ($usernameCount > 0) {
        echo "<script>alert('Username already exists!'); window.history.back();</script>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO register (fullname, email, studentID, username, password, gender, department) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $fullname, $email, $studentID, $username, $hashedPassword, $gender, $department);

        if ($stmt->execute()) {
            echo "<script>alert('YOU SUCCESSFULLY REGISTERED'); window.location.href = '#';</script>";
        } else {
            echo "<script>alert('Registration error: " . $stmt->error . "');</script>";
        }
        $stmt->close(); // Close the statement

        //test
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <!-- Include your CSS framework (Tailwind, Bootstrap, etc.) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Student Registration</h2>

        <form class="space-y-4" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <!-- Name -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Full Name</label>
                <input type="text" name="fullname" required
                    class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" name="email" required
                    class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Student ID -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Student ID</label>
                <input type="text" name="student-id" required
                    class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Username -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                <input type="text" name="username" required
                    class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <input type="password" name="password" required
                    class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Gender -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <input type="radio" name="gender" id="male" value="Male" class="w-4 h-4 text-blue-600">
                        <label for="male" class="ml-2 text-sm text-gray-900">Male</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="gender" id="female" value="Female" class="w-4 h-4 text-blue-600">
                        <label for="female" class="ml-2 text-sm text-gray-900">Female</label>
                    </div>
                </div>
            </div>

            <!-- Department -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Department</label>
                <select class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" name="department">
                    <option value="">Select Department</option>
                    <option value="CITCS">CITCS</option>
                    <option value="CAS">CAS</option>
                    <option value="CTE">CTE</option>
                    <option value="CEA">CEA</option>
                    <option value="CHS">CHS</option>
                    <option value="ETC">ETC</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="submit"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Register
            </button>
        </form>
    </div>
    <!-- Add your JavaScript file after the HTML -->
    <script src="script.js"></script>
</body>
</html>