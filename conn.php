<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'medalliontheatredb';
$conn = '';

try{
    $conn = new mysqli($host, $username, $password, $database);
}catch(mysqli_sql_exception){
    echo "Could not connect";
}if($conn){
    //  echo "Connected";
}
?>
