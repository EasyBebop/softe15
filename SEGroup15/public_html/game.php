<?php
    session_start();
?>

<!DOCTYPE HTML>
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
    }
    else
    {
        $score = 0; 
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
              font-size: 25px; } 
              
            .option:hover { 
              -moz-box-shadow: 0 0 20px #ccc; 
              -webkit-box-shadow: 0 0 20px #ccc; 
              box-shadow: 0 0 10px #ccc; }
    </style>
    <title>Playing a game</title>
    <a href="index.php">
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
                echo "<script type='text/javascript'>alert(\"TOO BAD! that's not correct!\");</script>";
            }
        }
    ?>
    </head>
    
    <!--show content-->
    <body>
        
        <div class="accountInfo">
            <br> Currently logged in as <strong><?php echo $user; ?></strong> 
        </div>
        
        <img style="position:absolute; left:0; right:0; top:5em; margin:auto;" src="navbar.png" alt="navbar" width="70%" height="5%">             
        
        <!-- question -->
        <br><p> <?php echo $question ?> <p>
        
        <!-- options -->  
        <?php
        echo "<br> Your score: $score<br>";
        for( $i = 0; $i < sizeof($options); $i++)
        {
             echo "<div> 
                
            <form method=\"post\" action=\"\" name=\"option$i\" id=\"option$i\">
                <input type=\"hidden\" name=\"answer\" id=\"answer\" value=\"$options[$i]\">
                <input type=\"hidden\" name=\"pastQ\" id=\"pastQ\" value=\"$questionID\">
                <input type=\"hidden\" name=\"score\" id=\"score\" value=\"$score\">    
                <br><br><br>
                <a class=\"option\" href=\"#\" onclick=\"document.option$i.submit();\">$options[$i]</a> 
            </form>
            </div> <br><br>";
        }
        ?>
    </body>  
</html>