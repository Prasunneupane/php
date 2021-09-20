<?php
include_once("at_class.php");
if(isset($_POST['update']))
{	


$emp_name = mysqli_real_escape_string($mysqli, $_POST['emp_name']);
$emp_gender = mysqli_real_escape_string($mysqli, $_POST['emp_gender']);
$emp_number = mysqli_real_escape_string($mysqli, $_POST['emp_number']);	
if(empty($emp_name) || empty($emp_gender) || empty($emp_number)) {	
if(empty($emp_name)) {
echo '<font color="red">Name field is empty.</font><br>';
}
if(empty($emp_gender)) {
echo '<font color="red">Gender field is empty.</font><br>';
}
if(empty($emp_number)) {
echo '<font color="red">Mobile Number field is empty.</font><br>';
}		
} else {	
$result = mysqli_query($mysqli, "UPDATE emp_detail SET  emp_name='$emp_name',emp_gender='$emp_gender',emp_number='$emp_number' WHERE id='" . $_GET["id"] . "'");
header("Location: table-master.php");
}
}
?>
