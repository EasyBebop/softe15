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
              position: relative;
              text-align: center;
              left: 37.5em;
              right: 37.5em;
              width: 10.8em;
              height: 55%;
              padding: 0px; }
              
    </style>
    
    <a href="index-boot.php">
      <img style="
        position: relative; 
        display: block; 
        margin: auto; 
        width: 35em; min-width: 30; 
        height: 6em; min-height: 4em;"
        color: rgba(46, 19, 178, 0); 
        src="logo.png" alt="T.R.I.V.I.A"></a>
        
        <meta charset="UTF-8">
        <title>Create an Account </title>
    </head>
   
    <body>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        
    <!--show content-->
    <div class="accountInfo">
        <br> Currently logged in as <strong><?php echo $user;
        if(isset($_SESSION['username']))
        {
        echo "<div id=\"logoutButton\">";
            echo "<form method=\"post\" action=\"index-boot.php\" name=\"logout\" id=\"logout\">";
                echo "<input type=\"submit\" class=\"btn btn-default\" value=\"Logout\" name=\"logoutOrder\">";
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
            <div class="col-lg-offset-4 col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align:center">
                        <h4>Create an Account</h4>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="" name="createForm" id="createForm">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Username:</label>
                                    <input type="text" autocomplete="off" class="form-control" name="username" id="username">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Password:</label>
                                    <input type="password" autocomplete="off" class="form-control" name="password" id="password">
                                </div>
                            </div>
                        </div>
                            <div class="panel-buttons">
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
