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
            echo "<script>alert('YOU SUCCESSFULLY REGISTERED'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Registration error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='../CSS/register.css' rel='stylesheet'>
</head>
<body>
<div class="wrapper border-dark shadow-lg">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1 class="exo-2 text-black mb-5">Student Registration</h1>
        <div class="exo-2 select-container">
            <!-- Full Name -->
            <div class="input-box exo-2">
                <input type="text" name="fullname" id="fullname" required autocomplete="off">
                <div class="labelLine">Full Name</div>
            </div>

            <!-- Email -->
            <div class="input-box exo-2">
                <input type="email" name="email" id="email" id="email" required autocomplete="off" placeholder="____">
                <div class="labelLine">Email Addr.</div>
            </div>

            <!-- Student ID -->
            <div class="input-box exo-2">
                <input type="text" name="student-id" id="student-id" required autocomplete="off">
                <div class="labelLine">Student ID</div>
            </div>

            <!-- Username -->
            <div class="input-box exo-2">
                <input type="text" name="username" id="username" required autocomplete="off">
                <div class="labelLine">Username</div>
                <i class='bx bxs-user text-darkerSoftYellow text-outline'></i>
            </div>

            <!-- Password -->
            <div class="input-box exo-2">
                <input type="password" name="password" id="password" required autocomplete="off">
                <div class="labelLine">Password</div>
                <i class='bx bxs-lock-alt text-darkerSoftYellow text-outline'></i>
            </div>

            <!-- Gender -->
            <div class="exo-2">
                <label class="labelLine"></label>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <!-- Department -->
            <div class="exo-2">
                <label class="labelLine"></label>
                <select name="department" required>
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
            <button type="submit" class="btn exo-2" name="submit">Register</button>
        </div>
    </form>
    <p class="mt-3 text-center exo-2">Already have an account? <a href="index.php" class="text-yellow text-outline">Login</a></p>
</div>
<script src="../JavaScript/script.js"></script>
</body>
</html>