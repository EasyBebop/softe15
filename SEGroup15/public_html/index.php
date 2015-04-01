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
        
<!--------------------layout-------------------->
        <style>
            .accountInfo {
              position: fixed; 
              top: -.5em; 
              margin-left: .5em; 
              color: rgba(41, 178, 38, 1); }
              
            html { 
              background-color:rgba(44, 1, 255, 1); }
              
            body { 
              position: absolute;
              background-color:white; 
              width:100%; 
              height:95%; 
              margin:0em; 
              padding:0em; }
            
            p { 
              position: relative; 
              text-align: center; 
              font-size:110%; }
              
            #form {
              position: absolute;
              text-align: left;
              width: 10.8em;
              height: 55%;
              padding: 5px;
              border-style: solid;
              border-color: rgba(41, 178, 38, 1);
              
              margin: 5px; }
            
            .click { 
              width: 150px; 
              border: 1px solid #9325BC; 
              padding: 10px; } 
            
            .click:hover { 
              -moz-box-shadow: 0 0 20px #ccc; 
              -webkit-box-shadow: 0 0 20px #ccc; 
              box-shadow: 0 0 10px #ccc; }
        </style>
        
        <title>T.R.I.V.I.A.</title>
        <a href="index.php">
          <img style="
            position:relative; 
            display:block; 
            margin: auto; 
            width: 35em; min-width: 30; 
            height: 6em; min-height: 4em;"
            color: rgba(46, 19, 178, 0); 
            src="logo.png" alt="T.R.I.V.I.A"></a>        
    </head>
    <body>
        <!--show content-->
    <div class="accountInfo">
        <br> Currently logged in as <strong><?php echo "$user";
        if(isset($_SESSION['username']))
        {
        echo "<div id=\"logoutButton\">";
            echo "<form method=\"post\" action=\"index.php\" name=\"logout\" id=\"logout\">";
                echo "<input type=\"submit\" value=\"Logout\" name=\"logoutOrder\">";
            echo "</form>";
        echo "</div>";
        }        
        ?></strong>        
    </div>
        <img style="position:absolute; left:0; right:0; top:5em; margin:auto;" src="navbar.png" alt="navbar" width="70%" height="5%">
        
        <a href="index.php">
          <img style="
            position:absolute; 
            left:17%; 
            top:5.2em;" 
            src="home.png" alt="navbar" width="5%" height="4%"></a>
        
        <a href="createAccount.php">
          <img style="
            position:absolute; 
            left:27%; 
            top:5.2em; 
            color: rgba(41, 178, 38, 0);" 
            src="createaccount.png" alt="navbar" width="10%" height="4%"></a>
        
        <a href="submitQ.php">
          <img style="
            position:absolute; 
            left:42%; 
            top:5.2em; 
            color: rgba(41, 178, 38, 0);" 
            src="submitq.png" alt="navbar" width="10%" height="4%"></a>
        
        <a href="friends.php">
          <img style="
            position:absolute; 
            left:57%; 
            top:5.2em; 
            color: rgba(41, 178, 38, 0);" 
            src="friends.png" alt="navbar" width="10%" height="4%"></a>

        <br><br><p> Welcome to the game of T.R.I.V.I.A<br>It is an acronym for something<br><br>Test your knowledge of useless facts here</p>
        
        <a href="game.php"> 
          <img class="click" style="
          position: absolute; 
          left: 0; 
          right: 0; 
          margin: auto;" 
          src="start.png" alt="start" width="15%" height="5%" onclick></a>
   
        <!--log in form-->
        <div id="form">
            <br><br><br><br><strong> <br>Login: </strong>
            <form method="post" action="" name="logForm" id="logForm"><br>
                Username: <input type="text" name="username" id="username"><br>
                Password: <input type="text" name="password" id="password"><br><br>
                <input type="image" style="position:relative; left:7em;"  src="submit.png" alt="submit" width="60" height="20">
            </form>
        </div>
    </body>
</html>

