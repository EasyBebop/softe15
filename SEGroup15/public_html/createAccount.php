<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<?php
$hostname = "173.194.82.183";
$username = "test";
$password = "test";

// Create connection
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("accounts",$dbhandle) 
  or die("Could not select examples");
?>


    <head>
    <a href="index.html"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
        <style>
            html{ background-color:#CCE6FF;}
            body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
            p{text-align: center; font-size:25px;}
            #form{margin-left:20px; font-size:20px;}
            
        </style>
   
        
        <meta charset="UTF-8">
        <title>T.R.I.V.I.A log in </title>
    </head>
    <body>
        
        <img style="position:absolute; left:0; right:0; top:130px;  margin:auto;" src="navbar.png" alt="navbar" width="900" height="40">
        <a href="index.html"><img style="position:absolute; left:270px; top:135px;" src="home.png" alt="navbar" width="60" height="30"></a>
        <a href="createAccount.php"><img style="position:absolute; left:370px; top:135px;" src="createaccount.png" alt="navbar" width="180" height="30"></a>
        <a href="submitQ.php"><img style="position:absolute; left:590px; top:135px;" src="submitq.png" alt="navbar" width="180" height="30"></a>
        <p> <br>Create a new account </p>
        <div id="form">
            <form method="post" action="" name="logForm" id="logForm"><br>
                 Username: <input type="text" name="username" id="username"><br>
                Password: <input type="text" name="password" id="password"><br>
                Confirm Password: <input type="text" name="confirmPassword" id="confirmPassword"><br><br>
                <a href="index.html"><img style="position:relative; left:20px;" src="back.png" alt="back" width="60" height="50"></a>
                <img style="position:relative; left:200px;" src="submit.png" alt="submit" width="80" height="50">
            </form>
        </div>
            
        <?php
        // put your code here
        ?>
    </body>
</html>
