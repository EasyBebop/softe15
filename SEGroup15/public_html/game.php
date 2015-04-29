<?php
    session_start();
?>

<!DOCTYPE HTML>
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
    $selected = mysql_select_db("questions",$dbhandle) 
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
    
    //keep score
    if(isset($_POST['score']))
    {
        $score = $_POST['score'];
        $incorrect = $_POST['incorrect'];
    }
    else
    {
        $score = 0;
        $incorrect = 0;
    }
    
    //get number of questions available
    $result1 = mysql_query("select count(1) FROM questions");
    $numRow = mysql_fetch_array($result1);
    $numOfQuestions = $numRow[0];
    
    //generate random question
    $random = mt_rand(1,$numOfQuestions);
    
    $sql = "SELECT * FROM questions WHERE QID = $random";
    $result2 = mysql_query($sql);
    $row = mysql_fetch_array($result2) or die(mysql_error());  
    $question = $row['Q'];
    $questionID = $row['QID'];
    $options = array("$row[correct]","$row[fake1]","$row[fake2]","$row[fake3]");
    shuffle($options);
    
    //functions
    
    function setHighscore($score)
    {
            global $dbhandle;
            if(isset($_SESSION['username']))
            {
                //Gain access to user database
                $selected = mysql_select_db("accounts",$dbhandle) 
                    or die("Could not select examples");
                
                $sql3 = "SELECT * FROM accounts WHERE username = \"$_SESSION[username]\"";
                $result3 = mysql_query($sql3);
                $row2 = mysql_fetch_array($result3) or die(mysql_error()); 
                $oldScore = $row2['score'];
                
                if($score > $oldScore)
                {
                    $sql4 = "UPDATE accounts SET score=\"$score\" WHERE AID=$_SESSION[id]";
                    $retval4 = mysql_query( $sql4, $dbhandle );
                }
                
                //set back to questions database
                $selected2 = mysql_select_db("questions",$dbhandle) 
                    or die("Could not select questions"); 
            }
              
    }
    
    ?>
    
    
        
    <title>Playing a game</title>
    <a href="index-boot.php">
      <img style="
        position:relative; 
        display:block; 
        margin: auto; 
        width: 35em; min-width: 30; 
        height: 6em; min-height: 4em;"
        color: rgba(46, 19, 178, 0); 
        src="logo.png" alt="T.R.I.V.I.A"></a>   

    <?php
        //check past answer
        if(isset($_POST['answer']))
        {
            $sql2 = "SELECT * FROM questions WHERE QID = $_POST[pastQ]";
            $query1 = mysql_query($sql2);
            $correct = mysql_fetch_array($query1);
            if($_POST['answer'] == $correct['correct'])
            {
                echo "<script type='text/javascript'>alert(\"GOOD! Correct answer\");</script>";            
                $score = $score + 10;
                setHighscore($score);
            }
            else
            {
                $incorrect++;
                echo "<script type='text/javascript'>alert(\"TOO BAD! that's not correct!\");</script>";
            }
        }
        
        if($incorrect < 3)
        {
    ?>
    </head>
    
    <!--show content-->
    <body>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <div class="accountInfo ">
            <h6>Currently logged in as <strong><?php echo $user; ?></strong></h6> 
        </div>
        
        <div class="panel panel-default full-height">
        <!-- question -->
        <div class="panel-heading">
            <div class="text-center">
                <h1> <?php echo $question ?> </h1>
            </div>
        </div>
        <div class="panel-body">
        <!-- options -->  
        <?php
        echo "<div class=\"row\"> "
                ."<div class=\"col-xs-12 col-sm-6 col-md-6 col-md-offset-3\">"
                . "<h4>Your score: $score</h4>"
                ."</div>"
            . "</div>";
        for( $i = 0; $i < sizeof($options); $i++)
        {
             echo "<div> 
                
            <form method=\"post\" action=\"\" name=\"option$i\" id=\"option$i\">
                <input type=\"hidden\" name=\"answer\" id=\"answer\" value=\"$options[$i]\">
                <input type=\"hidden\" name=\"pastQ\" id=\"pastQ\" value=\"$questionID\">
                <input type=\"hidden\" name=\"score\" id=\"score\" value=\"$score\">   
                <input type=\"hidden\" name=\"incorrect\" id=\"incorrect\" value=\"$incorrect\">
                <div class=\"row\">
                    <div class=\"col-xs-12 col-sm-6 col-md-6 col-md-offset-3\">
                        <button href=\"#\" type=\"submit\" class=\"option btn btn-lg btn-game btn-block\" onclick=\"document.option$i.submit();\">$options[$i]</button> 
                    </div>
                </div>
            </form>
            </div> <br><br>";
        }
        ?>
        </div>
        </div>
        
    
        <style>
            .accountInfo {
              position: fixed; 
              top: -.5em; 
              margin-left: .5em; 
              color: rgba(41, 178, 38, 1); }
            
            .btn-game { 
                color: #ffffff; 
                background-color: #2043b1; 
                border-color: #35488e; 
              } 

              .btn-game:hover, 
              .btn-game:focus, 
              .btn-game:active, 
              .btn-game.active, 
              .open .dropdown-toggle.btn-game { 
                color: #ffffff; 
                background-color: #49247A; 
                border-color: #130269; 
              } 

              .btn-game:active, 
              .btn-game.active, 
              .open .dropdown-toggle.btn-game { 
                background-image: none; 
              } 

              .btn-game.disabled, 
              .btn-game[disabled], 
              fieldset[disabled] .btn-game, 
              .btn-game.disabled:hover, 
              .btn-game[disabled]:hover, 
              fieldset[disabled] .btn-game:hover, 
              .btn-game.disabled:focus, 
              .btn-game[disabled]:focus, 
              fieldset[disabled] .btn-game:focus, 
              .btn-game.disabled:active, 
              .btn-game[disabled]:active, 
              fieldset[disabled] .btn-game:active, 
              .btn-game.disabled.active, 
              .btn-game[disabled].active, 
              fieldset[disabled] .btn-game.active { 
                background-color: #611BBD; 
                border-color: #130269; 
              } 

              .btn-game .badge { 
                color: #611BBD; 
                background-color: #ffffff; 
              }
        </style>
    
        <!--end if statement checking incorrect-->
        <?php
        }
        else{
        ?>
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

              .option { 
                text-decoration: none; 
                color: #204081; 
                width: 500px; 
                text-align: center; 
                border: 1px solid #9325BC; 
                padding: 10px; 
                position: absolute; 
                left: 0; 
                right: 0; 
                margin: auto; 
                font-size:25px; } 

              .option:hover { 
                -moz-box-shadow: 0 0 20px #ccc; 
                -webkit-box-shadow: 0 0 20px #ccc; 
                box-shadow: 0 0 10px #ccc; }
             </style>
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
        <?php
                 echo "<div class=\"col-xs-12 col-sm-12 col-md-8 col-lg-4 col-lg-offset-4\">"
                . "<div class\"panel panel-default\""
                . " <div class=\"panel-heading text-center\">"
                . "<h3>Too Bad! You've gotten too many questions wrong!</h3>"
                . "</div>"
                . "<div class=\"panel-body text-center\""
                . "Final Score: $score<br>";
        }
        ?>
    </body>  
</html>