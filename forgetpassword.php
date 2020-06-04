<?php

$error = NULL;

if(isset($_POST['submit'])){
    //get form data
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    //conect to database
    $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_bugTracker');
    
    $sel_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $results = mysqli_query($mysqli, $sel_query);
    
    
    //if eamil is not is table then error, else send email to email address
    if(mysqli_num_rows($results) == ""){
        $error .= "<p>This email address do not exsit in our system</p>";
        
    }else{
        //form is valid

        //send email
        $to = $email;
        $subject = "Reset Password";
        $message = "<a href='http://georgekassar.offyoucode.co.uk/BugTracker/resetpassword.php?email=$email'>Reset Password</a>";                              
        $headers = "From: georgekassar92@gmail.com \r\n";
        $headers .= "MIME-Version: 1.0". "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8". "\r\n";
            
        mail($to, $subject, $message, $headers);
            
        header('location:thankyouresetpassword.php');
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

  <title>Bug Tracker - Forgot Password</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                  </div>
                  <form method="POST" class="user">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email">
                    </div>
                      <input class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="Reset Password" required/>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="register.php">Create an Account!</a>
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
