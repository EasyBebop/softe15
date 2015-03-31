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
    //check session
    $user = "Guest";
    $id = -1;
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

    //check post, create account
    if(isset($_POST['username']) || isset($_POST['password']))
    {
        if(empty($_POST['username'])|| empty($_POST['password']))
            {
                    echo "Please fill in all fields to create an account. <br>";
            }
        else
        {
            $sql = 'SELECT AID, username, pass FROM accounts';

            $retval = mysql_query( $sql, $dbhandle );
            if(! $retval )
            {
               die('Could not get data: ' . mysql_error());
            }

            $taken = false;
            while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
            {
                if($_POST['username'] == $row['username'])
                {
                    $taken = true;
                    echo "<br>Username already taken.";
                    break;
                }
            }
            if($taken == false)
            {
                $sql2 = "INSERT INTO accounts (username,pass)
                         VALUES ('$_POST[username]', '$_POST[password]')";
                $retval2 = mysql_query( $sql2, $dbhandle );
                echo "<br>Created account successfully";
            }
        }
    } 
    ?>    

    <!--layout-->
    <a href="index.php"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
        <style>
            html{ background-color:#CCE6FF;}
            body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
            p{text-align: center; font-size:25px;}
            #form{margin-left:20px; font-size:20px;}
        </style>

        <meta charset="UTF-8">
        <title>T.R.I.V.I.A Create an Account </title>
    </head>
   
    <body>
    <!--show content-->
    <div class="accountInfo">
        <br> Currently logged in as <?php echo $user;
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
    <p> <br>Create a new account </p>
    <div id="form">
        <form method="post" action="" name="createForm" id="createForm"><br>
            Username: <input type="text" name="username" id="username"><br>
            Password: <input type="text" name="password" id="password"><br><br>
            <a href="index.php"><img style="position:relative; left:20px;" src="back.png" alt="back" width="60" height="50"></a>
            <input type="image" style="position:relative; left:200px;"  src="submit.png" alt="submit" width="80" height="50">
        </form>
    </div>
    </body>
</html>
