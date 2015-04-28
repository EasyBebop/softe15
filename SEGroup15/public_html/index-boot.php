<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        
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
            $sql = 'SELECT * FROM accounts';

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
                        $_SESSION['score'] = $row['score'];
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
              box-shadow: 0 0 10px #ccc;
            
            }
            
            .navbar-nav {
                
            }
        </style>
        
        <title>T.R.I.V.I.A.</title>
        <div class="container">
            <a href="index-boot.php">
              <img style="
                position:relative; 
                display:block; 
                margin: auto; 
                width: 35em; min-width: 30; 
                height: 6em; min-height: 4em;"
                color: rgba(46, 19, 178, 0); 
                src="logo.png" alt="T.R.I.V.I.A">
            </a> 
        </div>
    </head>
    <body>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <!--show content-->
    <div class="accountInfo">
        <br> Currently logged in as <strong><?php echo "$user";
        if(isset($_SESSION['username']))
        {
        echo "<div id=\"logoutButton\">";
            echo "<form method=\"post\" action=\"index-boot.php\" name=\"logout\" id=\"logout\">";
                echo "<input class=\"btn btn-default\" type=\"submit\" value=\"Logout\" name=\"logoutOrder\">";
            echo "</form>";
        echo "</div>";
        }        
        ?></strong>        
    </div>
        <div class="container-fluid">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                        <ul class="nav nav-justified" style="text-align:center">
                            <li><a href="index-boot.php">Home</a></li>
                            <li><a href="createAccount-boot.php">Create Account</a></li>
                            <li><a href="submitQ-boot.php">Submit Question</a></li>
                            <li><a href="friends-boot.php">Friends</a></li>
                            <li><a href="leaderboard-boot.php">Leaderboard</a></li>
                        </ul>
                </div>
            </nav>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4">
                                    <h3 class="text-center"> Welcome to the game of T.R.I.V.I.A</h3>
                                    <h5 class="text-center">Test your knowledge of useless facts here</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-md-offset-3 col-lg-offset-3">
                                    <a class="btn btn-primary btn-block btn-block btn-lg" href="game.php">Start!</a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    <a class="btn btn-primary btn-block btn-lg" href="timedgame-boot.php"> Time Attack!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5>Login</h5>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="" name="logForm" id="logForm"><br>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Username:</label>
                                        <input class="form-control" autocomplete="off" type="text" name="username" id="username">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Password:</label>
                                        <input class="form-control" autocomplete="off" type="password" name="password" id="password">
                                    </div>
                                </div>
                            </div>
                                <div class="panel-buttons pull-right">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

