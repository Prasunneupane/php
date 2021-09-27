<?php
require_once "config.php";


require 'includes/PHPMailer.php';
 require 'includes/SMTP.php';
 require 'includes/Exception.php';

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;


 if(isset($_POST['submit_email']) && $_POST['email'])
{
    
     $emailId = $_POST['email'];
 
    $result = mysqli_query($mysqli,"SELECT * FROM admins WHERE email='" . $emailId . "' ");
 
    $row= mysqli_fetch_array($result);
 
  if($row)
  {
     
     $token = md5($emailId).rand(10,9999);
 
     $expFormat = mktime(
     date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
     );
 
    $expDate = date("Y-m-d H:i:s",$expFormat);
 
   // $update = mysqli_query($mysqli,"UPDATE admins SET  password ='" . $password . "', reset_link_token='" . $token . "' ,exp_date='" . $expDate . "' WHERE email='" . $emailId . "'");
 
    $link = "<a href='http://localhost/liteadmin/php/forgot-password.php?key=".$emailId."&token=".$token."'>Click To Reset password</a>";
 
    
 
    $mail = new PHPMailer();
 
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "user@example.com";
    // GMAIL password
    $mail->Password = "secret";
    $mail->SMTPSecure = "ssl";  
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    //set sender email
    $mail->From='prasunneupane14@gmail.com';
    //set sender name
    $mail->FromName='Prasun Neupane';
    // set reciever email
    $mail->AddAddress= ('prasunneupane14@gmail.com');
    //set subject
    $mail->Subject  =  'Reset Password';
    $mail->IsHTML(true);
    $mail->Body    = 'Click On This Link to Reset Password '.$link.'';
    if($mail->Send())
    {
      echo "Check Your Email and Click on the link sent to your email";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }
  }else{
    echo "Invalid Email Address. Go back";
  }
}

?>
