<?php
$host='localhost';
$user='root';
$pass='';
$db='softeng-login';
$conn=new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    echo "Failed to connect to the database".$conn->connect_error;
}

if($conn){
    //echo "Connected to the database";
}
?>