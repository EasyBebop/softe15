<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        
    <?php
    $hostname = "173.194.82.183";
    $username = "test";
    $password = "test";

    // Create connection
    $dbhandle = mysql_connect($hostname, $username, $password) 
      or die("Unable to connect to MySQL");

    //select a database to work with
    $selected = mysql_select_db("accounts",$dbhandle) 
      or die("Could not select examples");
    
    //logout
    if(isset($_POST['logoutOrder']))
    {
       logout();
    }
    
    //check post, log in
    $user = "Guest";
    $id = -1;
    if(isset($_POST['username']) || isset($_POST['password']))
    {
        if(empty($_POST['username'])|| empty($_POST['password']))
            {
                    echo "<br>Please fill in all fields to log in <br>";
            }
        else
        {
            $sql = 'SELECT AID, username, pass, friends FROM accounts';

            $retval = mysql_query( $sql, $dbhandle );
            if(! $retval )
            {
               die('Could not get data: ' . mysql_error());
            }
                
            // loop and search in accounts
            $accountFound = false;
            while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
            {
                if($_POST['username'] == $row['username'])
                {
                    $accountFound = true;
                    if($_POST['password'] == $row['pass'])
                    { 
                        $_SESSION['username'] = $_POST['username'];
                        $user = $_SESSION['username'];
                        $_SESSION['id'] = $row['AID'];
                        $id = $_SESSION['id'];
                        $_SESSION['friends'] = $row['friends'];
                        break;
                    }
                    else
                    {
                        echo "<br>Password is incorrect";
                    }
                }
            }
            if($accountFound == false)
            {
                echo "<br>Account does not exist";
            }
        }
    }
    
    //check session
    if(isset($_SESSION['username']))
    {
        $user = $_SESSION['username'];
        $id = $_SESSION['id'];
    }
    
    //logout function
    function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }
    ?>
        
        <!--layout-->
        <title>T.R.I.V.I.A.</title>
        <a href="index.php"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
        <style>
            html{ background-color:#CCE6FF;}
            body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
            p{text-align: center; font-size:25px;}
            .click { width: 150px; border: 1px solid #9325BC; padding: 10px; } 
            .click:hover { -moz-box-shadow: 0 0 20px #ccc; -webkit-box-shadow: 0 0 20px #ccc; box-shadow: 0 0 10px #ccc; }
        </style>
    </head>
    <body>
        <!--show content-->
    <div class="accountInfo">
        <br> Currently logged in as <?php echo "$user";
        if(isset($_SESSION['username']))
        {
        echo "<div id=\"logoutButton\">";
            echo "<form method=\"post\" action=\"index.php\" name=\"logout\" id=\"logout\">";
                echo "<input type=\"submit\" value=\"Logout\" name=\"logoutOrder\">";
            echo "</form>";
        echo "</div>";
        }        
        ?>        
    </div>
        <img style="position:absolute; left:0; right:0; top:130px;  margin:auto;" src="navbar.png" alt="navbar" width="900" height="40">
        <a href="index.php"><img style="position:absolute; left:270px; top:135px;" src="home.png" alt="navbar" width="60" height="30"></a>
        <a href="createAccount.php"><img style="position:absolute; left:370px; top:135px;" src="createaccount.png" alt="navbar" width="180" height="30"></a>
        <a href="submitQ.php"><img style="position:absolute; left:590px; top:135px;" src="submitq.png" alt="navbar" width="180" height="30"></a>
        <a href="friends.php"><img style="position:absolute; left:800px; top:135px;" src="friends.png" alt="navbar" width="150" height="30"></a>

        <br><br><p> Welcome to the game of T.R.I.V.I.A<br>It is an acronym for something<br><br>Test your knowledge of useless facts here</p>
        
        <a href="game.php"> <img class="click" style="position:absolute; left:0; right:0; margin:auto;" src="start.png" alt="start" width="150" height="40" onclick></a>
   
        <!--log in form-->
        <div id="form">
            <br><br><br><br><div> <br>Log In </div>
            <form method="post" action="" name="logForm" id="logForm"><br>
                Username: <input type="text" name="username" id="username"><br>
                Password: <input type="text" name="password" id="password"><br><br>
                <input type="image" style="position:relative; left:100px;"  src="submit.png" alt="submit" width="80" height="50">
            </form>
        </div>
    </body>
</html>

