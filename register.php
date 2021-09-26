<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $email = $confirm_password = "";
$username_err = $password_err = $email_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    //validate email

    if(empty(trim($_POST["email"]))){
      $email_err = "Please enter a email.";
  } elseif(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', trim($_POST["email"]))){
      $email_err = "Email can contain special characters numbers,letters.";
  } else{
      // Prepare a select statement
      $sql = "SELECT id FROM admins WHERE email = ?";
      
      if($stmt = mysqli_prepare($mysqli, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "s",$param_email);
          
          // Set parameters
          $param_email = trim($_POST["email"]);
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              /* store result */
              mysqli_stmt_store_result($stmt);
              
              if(mysqli_stmt_num_rows($stmt) == 1){
                  $email_err = "This email is already taken.";
              } else{
                  $email = trim($_POST["email"]);
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }

          // Close statement
          mysqli_stmt_close($stmt);
      }
  }


//Validate Password
if(empty(trim($_POST["password"]))){
  $password_err = "Please enter a password.";     
} elseif(strlen(trim($_POST["password"])) < 6){
  $password_err = "Password must have atleast 6 characters.";
} else{
  $password = trim($_POST["password"]);
}

// Validate confirm password
if(empty(trim($_POST["confirm_password"]))){
  $confirm_password_err = "Please confirm password.";     
} else{
  $confirm_password = trim($_POST["confirm_password"]);
  if(empty($password_err) && ($password != $confirm_password)){
      $confirm_password_err = "Password did not match.";
  }
}

// Check input errors before inserting in database
if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) ){
  
  // Prepare an insert statement
  $sql = "INSERT INTO admins (username, password,email) VALUES (?, ?,?)";
   
  if($stmt = mysqli_prepare($mysqli, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
      
      // Set parameters
      $param_username = $username;
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
     

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
          // Redirect to login page
          header("location: login.php");
      } else{
          echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
  }
}

// Close connection
mysqli_close($mysqli);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="input-group mb-3">
          <input type="text"  placeholder="Username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"><?php echo $username_err;?></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text"  placeholder="Email" name="email" class="form-control <?php echo (!empty($email)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"><?php echo $email_err;?></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"><?php echo $password_err; ?></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirm password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"><?php echo $password_err; ?></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
          
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          
          </div>
          <!-- /.col -->
        </div>
      </form>
        <a href="login.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
