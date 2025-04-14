<?php
include('connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (empty($username) || empty($password)) {
        echo "
            <script>alert('PLEASE FILL THE USERNAME/PASSWORD');</script>
            ";
    } else {
        // Fetch the hashed password and usertype from the database
        $stmt = $conn->prepare("SELECT password FROM register WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Verify the password using password_verify()
            if (password_verify($password, $row["password"])) {
               
                    $_SESSION["username"] = $username;
                    header("Location:home.php");
                    exit;
                } 
        }
        else {
                echo "
            <script>alert('WRONG USERNAME/PASSWORD');</script>
            ";
            }
        $stmt->close();
    }


}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign in</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href='../CSS/main.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
<body>
<div class="wrapper border-dark shadow-lg">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <h1 class="exo-2 text-black mb-5">Welcome</h1>
    <div class="exo-2 select-container">
    <div class="input-box exo-2">
        <input class="lavender-gray" type="text" placeholder="" name="username" id="username" required autocomplete="off">
        <div class="labelLine">Username</div>
        <i class='bx bxs-user text-darkerSoftYellow text-outline'></i>
    </div>
    <div class="input-box exo-2">
        <input type="password" placeholder="" name="password" id="password" required autocomplete="off">
        <div class="labelLine">Password</div>
        <i class='bx bxs-lock-alt text-darkerSoftYellow text-outline' ></i>
    </div>
    <div class="remember-forgot exo-2 text-black">
        <!-- <label><input type="checkbox" class="opacity-50">Remember Me</label> -->
    </div>
    <button type="submit" class="btn exo-2" name="login" value="login">Login</button>
    </form>
</div>
<script src="../JavaScript/script.js"></script>     
</body>
</html>