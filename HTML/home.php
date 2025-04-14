<?php
    session_start();
    include('connect.php');
    if (!isset($_SESSION["username"])) {
        header("location:index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <h1>Hello <?php echo $_SESSION['username'] ?>
            <!--
            <?php
                $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.username='$username'");
                while($row=mysqli_fetch_array($query)){
                    echo $row['username'];
                }
            ?>
            -->
        </h1>
    </body>
</html>