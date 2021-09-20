<?php
$databaseHost = 'localhost';
$databaseName = 'test';
$databaseUsername = 'root';
$databasePassword = '';
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, 
$databaseName);  

if(!$mysqli){
    echo "<h1> Error in Database</h1>";
    die();
}
?>