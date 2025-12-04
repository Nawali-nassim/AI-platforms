<?php
$hostNme="localhost";
$userName="root";
$password="";
$dbName="AI_platform_users";
$con=mysqli_connect($hostNme,$userName,$password,$dbName);
if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>