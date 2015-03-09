<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
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
