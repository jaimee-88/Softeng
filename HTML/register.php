<?php 
include('connect.php');

if(isset($_POST['login'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    
    $sql="SELECT * FROM users WHERE username='$username' and password='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
    session_start();
    $row=$result->fetch_assoc();
    $_SESSION['username']=$row['username'];
    header("Location: home.php");
    exit();
    }
    else{
    echo "Not Found, Incorrect Email or Password";
    }
}
?>