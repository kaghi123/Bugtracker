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
        $vkey = md5(time().$u);
        
        
        //insert accounts into the database
        
        $insert = $mysqli->query("INSERT INTO users (first_name, last_name, email, password, type, vkey) VALUES ('$fname', '$lname', '$email', '$password', 'manager' ,'$vkey')");
        
        
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