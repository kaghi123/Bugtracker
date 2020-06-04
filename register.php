<?php

$error = NULL;

if(isset($_POST['submit'])){
    //get form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];
    
    //conect to database
    $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_bugTracker');
    
    $sel_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $results = mysqli_query($mysqli, $sel_query);
    
    if(strlen($password) < 6){
        $error = "<p>Your password should be at least 6 characters</p>";
    }elseif($p2 != $p){
        $error .= "<p>Your passwords do not match</p>";
    }elseif(!mysqli_num_rows($results) == ""){
        $error .= "<p>This email already exists.</p>";
    }else{
        //form is valid
        
        
        
        //sanitize form data
        $fname = $mysqli->real_escape_string($fname);
        $lname = $mysqli->real_escape_string($lname);
        $password = $mysqli->real_escape_string($password);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $email = $mysqli->real_escape_string($email);
        
        //generate vkey
        $vkey = md5(time().$email);
        
        
        //insert accounts into the database
        
        $insert = $mysqli->query("INSERT INTO users (first_name, last_name, email, password, type, vkey) VALUES ('$fname', '$lname', '$email', '$password', 'Manager' ,'$vkey')");
        
        
        
        if($insert){
            //send email
            $to = $email;
            $subject = "Email Verification";
            $message = "<a href='http://georgekassar.offyoucode.co.uk/BugTracker/verify.php?vkey=$vkey'>Register Account</a>";
            $headers = "From: georgekassar92@gmail.com \r\n";
            $headers .= "MIME-Version: 1.0". "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8". "\r\n";
            
            mail($to, $subject, $message, $headers);
            
            header('location:thankyou.php');
        }else{
            echo $mysqli->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Bug Tracker - Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form method="POST" class="user">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name" name="fname" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" placeholder="Last Name" name="lname" required>
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" name="email" required>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password" name="password2" required>
                  </div>
                </div>
                  <input class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="Register Account" required/>
                <hr>
<!--                  maybe get rid of these-->
                <a href="#" class="btn btn-google btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="#" class="btn btn-facebook btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgetpassword.php">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="login.php">Already have an account? Login!</a>
              </div>
                <div>
                    <?php 
                        echo $error;
                    ?>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>