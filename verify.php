<?php

if(isset($_GET['vkey'])){
    //process verification
    $vkey = $_GET['vkey'];
    
    $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_bugTracker');
        
    $resultSet = $mysqli-> query("SELECT verified, vkey FROM users WHERE verified = 0 AND vkey = '$vkey' LIMIT 1");
    
    if($resultSet->num_rows == 1){
        //validate the  email
        $update = $mysqli->query("UPDATE users SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");
        
        if($update){
            echo "Your account has been verified. You may now login.";
            $link = "http://georgekassar.offyoucode.co.uk/BugTracker/login.php";
            echo "   ";
            echo "<a href='".$link."'>Login</a>";
        }else {
            echo $mysqli->error;
        }
        
    }else {
        echo "This account is invalid or already verified";
    }
    
}else {
    die("Something went wrong");
}

?>
<html>
    <head>
    </head>
    <body>
        
        <center>
            
        </center>
    </body>
</html>