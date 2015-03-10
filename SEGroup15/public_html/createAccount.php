<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    
    <?php
$servername = "173.194.82.183";
$username = "test";
$password = "test";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>
    
    <?php
$username = "test";
$password = "test";
$hostname = "2001:4860:4864:1:7561:8ee5:1944:f272"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";
?>
    
    <head>
        <img style="position:absolute; left:0; right:0; top:-100px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="300">
        <style>
            html{ background-color:#CCE6FF;}
            body{ margin-left:250px; margin-right:250px;margin-top:130px; margin-bottom:130px; background-color: white; height:900px;}
            p{text-align: center; font-size:25px;}
            #form{margin-left:20px; font-size:20px;}
            
        </style>
   
        
        <meta charset="UTF-8">
        <title>T.R.I.V.I.A log in </title>
    </head>
    <body>
        
        <p> <br>Create a new account </p>
        <div id="form">
            <form method="post" action="" name="logForm" id="logForm"><br>
                 Username: <input type="text" name="username" id="username"><br>
                Password: <input type="text" name="password" id="password"><br>
                Confirm Password: <input type="text" name="confirmPassword" id="confirmPassword"><br><br>
                <img style="position:relative; left:20px;" src="back.png" alt="back" width="60" height="60">
                <img style="position:relative; left:200px;" src="submit.png" alt="submit" width="60" height="60">
            </form>
        </div>
            
        <?php
        // put your code here
        ?>
    </body>
</html>
