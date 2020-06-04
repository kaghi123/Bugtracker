<?php

if(isset($_GET['vkey'], $_GET['email'])){
    //process verification
    $vkey = $_GET['vkey'];
    $email = $_GET['email'];
    
    $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_bugTracker');
    
    // Initialize message variable
    $msg = "";
    
    
    if(isset($_POST['submit'])){
        
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        
        if(strlen($password) < 6){
            $error = "<p>Your password should be at least 6 characters</p>";
        }elseif($password2 != $password){
            $error .= "<p>Your passwords do not match</p>";
        }else{
        
            //sanitize form data
            $password = $mysqli->real_escape_string($password);
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $resultSet = $mysqli-> query("SELECT verified, vkey FROM users WHERE verified = 0 AND vkey = '$vkey' LIMIT 1");
            
            if($resultSet->num_rows == 1){
        
                //validate the  email
                $update = $mysqli->query("UPDATE users SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");
    
                if($update){
        
                    //update password in the database
                    $update1 = $mysqli->query("UPDATE users SET password = '$password' WHERE email = '$email'");
        
                    if($update1){
                        $message .=  "Your account has been verified. You may now login.";
                        $link = "http://georgekassar.offyoucode.co.uk/BugTracker/login.php";
                        $message .= "<a href='".$link."'>Login</a>";
                    }else {
                        echo $mysqli->error;
                    }
        
                }else {
                    echo "This account is invalid or already verified";
                }
            }
        }
        
    }
    
}else {
    die("Something went wrong");
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

  <title>Bug Tracker - Enter A Password</title>

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
                    <h1 class="h4 text-gray-900 mb-2">Enter A Password</h1>
                    <p class="mb-4">Enter in a Password</p>
                  </div>
                  <form method="POST" class="user">
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="passwordHelp" placeholder="Enter A Password" name="password">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="passwordHelp" placeholder="Repeat Password" name="password2">
                    </div>
                      <input class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="Set Password" required/>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="login.php">Already have an account? Login!</a>
                  </div>
                    <div>
                    <?php 
                        echo $error;
                        echo $message;
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