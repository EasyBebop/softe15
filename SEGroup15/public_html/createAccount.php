<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        
        <style>
            html{ background-color : gray ;}
            body{ margin: 50px; background-color: white; height:500px;}
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
                <input type="submit" value="Submit" form_id="cform"><br><br>
            </form>
        </div>
            
        <?php
        // put your code here
        ?>
    </body>
</html>
