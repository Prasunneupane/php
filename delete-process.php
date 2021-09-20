<html>
    <head>
        <meta http-equiv="refresh" content="0;url=table-master.php">
    </head>
</html>
<?php
include('at_class.php');
$sql = "DELETE FROM emp_detail WHERE id='" . $_GET["id"] . "'";
if (mysqli_query($mysqli, $sql)) {
    
  
} else {
    echo "Error deleting record: " . mysqli_error($mysqli);
}

mysqli_close($mysqli);
?>
