<?php
if($_POST){
$emp_file = $_FILES['emp_file'];
 // //print_r($files);
  //echo "<br>";
  //print_r($emp_name);
  $filename = $emp_file['name'];
  $fileerror = $emp_file['error'];
  $filetemp = $emp_file['tmp_name'];
  $fileext = explode('.',$filename);
  $filecheck = strtolower(end($fileext));
  $fileextstored = array('png','jpg','jpeg','gif');
if(in_array($filecheck,$fileextstored)){
  $destinationfile ='upload/'.$filename;
  move_uploaded_file($filetemp,$destinationfile);
   
  $q = mysqli_query($mysqli,"UPDATE emp_detail SET emp_file = '$destinationfile' WHERE id=$id ");
  $query = mysqli_query($mysqli,$q);
  if($query){
    echo "<script>alert('Record Added');</script>";
  }
}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>jQuery Show upload button instead of file upload</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript">
$(function () {
$("#fileupload1").change(function () {
$("#spnName").html($("#fileupload1").val().substring($("#fileupload1").val().lastIndexOf('\\') + 1));
});
});
</script>
<style type="text/css">
.button {
background: #333;
color: #fff;
padding: 10px 15px;
border-radius: 5px;
}
.button:hover {
background: #51A8CA;
}
</style>
</head>
<body>
<form id="form1">
<div><br/>
<input style="display:none" type="file" id="fileupload1" />
<input type="button" class="button" id="btnUpload" onclick='$("#fileupload1").click()' value="Upload"/>
<span id="spnName"></span>
</div>
</form>  <link> This is the link to the website that goues towards to hera pheri chowk aint the dadad</link>
</body>
</html>