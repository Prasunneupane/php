<?php
$databaseHost = 'localhost';
$databaseName = 'test';
$databaseUsername = 'root';
$databasePassword = '';
$link = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, 
$databaseName);  

if(!$link){
    echo "<h1> Error in Database</h1>";
    die();
}
?>