<?php
session_start();

$error = NULL;

if(isset($_SESSION['email'])){
    header('location:index.php');
}

if(isset($_POST['submit'])){
    //conect to database
    $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_bugTracker');
    
    //get form data
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    
    
    //query the database
    $resultSet = $mysqli->query("SELECT * FROM users WHERE email = '$email' LIMIT 1");
    
    if($resultSet->num_rows !=0){
//        //proccess login
        
        while($row = $resultSet->fetch_assoc()){
            
            if(password_verify($password, $row['password'])){
                $verified = $row['verified'];
                $email = $row['email'];
                $date = $row['createdate'];
                $date = strtotime($date);
                $date = date('M d Y', $date);

                if($verified == 1){
                    //continue proccessing
                    $_SESSION['email'] = $email;
                    
                    if(!empty($_POST['remember'])){
                        setcookie('emailre', $_POST['email'], time() + (10 * 365 * 24 * 60 * 60));
                        setcookie('passre', $_POST['password'], time() + (10 * 365 * 24 * 60 * 60));
                    }else{
                        if(isset($_COOKIE['emailre'])){
                            setcookie("emailre", "");
                        }if(isset($_COOKIE['passre'])){
                            setcookie("passre", "");
                        }
                    }
                    
                    header('location:index.php');
                    
                }else{
                    $error = "This account has not yet been verified. An email was sent to $email on $date";
                }
            }else {
                //invalid credentials
                $error = "The username or password you entered is incorrect";
            }
        }
    
    }else{
        $error = "The username or password you entered is incorrect";
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

  <title>Bug Tracker Login</title>

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
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form method="POST" class="user">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" value="<?php if(isset($_COOKIE["emailre"])) {echo $_COOKIE["emailre"];} ?>" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" value="<?php if(isset($_COOKIE["passre"])) {echo $_COOKIE["passre"];} ?>" required>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" <?php if(isset($_COOKIE["emailre"])) { ?> checked <?php } ?>>
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                      <input class="btn btn-primary btn-user btn-block" type="SUBMIT" name="submit" value="Login" required/>
                    <hr>
<!--                      maybe delete login with google or facebook-->
                    <a href="#" class="btn btn-google btn-user btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="#" class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgetpassword.php">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.php">Create an Account!</a>
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
