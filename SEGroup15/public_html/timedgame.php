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
    
    //keep score
    if(isset($_POST['score']))
    {
        $score = $_POST['score'];
        $opponent = $_POST['opponent'];
        if($score < 1)
        {
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
            ?>

            <!--layout-->    
            <title>Time Attack!!</title>
            <a href="index.php"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
                <style>
                    html{ background-color:#CCE6FF;}
                    body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
                    p{text-align: center; font-size:25px;}
                    .option { text-decoration:none; color: #204081; width: 500px; text-align: center; border: 1px solid #9325BC; padding: 10px; position:absolute; left:0; right:0; margin:auto; font-size:25px; } 
                    .option:hover { -moz-box-shadow: 0 0 20px #ccc; -webkit-box-shadow: 0 0 20px #ccc; box-shadow: 0 0 10px #ccc; }
                </style>

            <?php
                //check past answer
                if(isset($_POST['answer']))
                {
                    $sql2 = "SELECT * FROM questions WHERE QID = $_POST[pastQ]";
                    $query1 = mysql_query($sql2);
                    $correct = mysql_fetch_array($query1);
                    if($_POST[answer] == $correct[correct])
                    {          
                       $score = $score + 1;
                    }
                    else
                    {
                    }
                }

            ?>
            </head>

            <!--show content-->
            <body>
                <img style="position:absolute; left:0; right:0; top:130px;  margin:auto;" src="navbar.png" alt="navbar" width="900" height="40">

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
                        <input type=\"hidden\" name=\"opponent\" id=\"opponent\" value=\"$opponent\">
                        <br><br><br>
                        <a class=\"option\" href=\"#\" onclick=\"document.option$i.submit();\">$options[$i]</a> 
                    </form>
                    </div> <br><br>";
                }
        }
        else{
        ?>
        <title>Time Attack!!</title>
            <a href="index.php"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
                <style>
                    html{ background-color:#CCE6FF;}
                    body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
                    p{text-align: center; font-size:25px;}
                    .option { text-decoration:none; color: #204081; width: 500px; text-align: center; border: 1px solid #9325BC; padding: 10px; position:absolute; left:0; right:0; margin:auto; font-size:25px; } 
                    .option:hover { -moz-box-shadow: 0 0 20px #ccc; -webkit-box-shadow: 0 0 20px #ccc; box-shadow: 0 0 10px #ccc; }
                </style>
        <?php
            //Gain access to user database
            $selected = mysql_select_db("accounts",$dbhandle) 
                or die("Could not select examples");
            //Pulls opponent's time from database and checks it against player time
            $opponentname = $_POST['opponent'];
            $playerid = $_SESSION['id'];
            
            $sql3 = "SELECT * FROM accounts WHERE username =\"$opponentname\"";
            $result3 = mysql_query($sql3);
            $row2 = mysql_fetch_array($result3) or die(mysql_error()); 
            $opponenttime = $row2['time'];
              
            $sql4 = "SELECT * FROM accounts WHERE AID =\"$playerid\"";
            $result4 = mysql_query($sql4);
            $row3 = mysql_fetch_array($result4) or die(mysql_error()); 
            $user_time = $row3['time'];
                    
            $time_finish = microtime(true);
            $time_final = $time_finish - $_SESSION['starttime'];
            echo "You made it this far<br>";
            echo "End Time: $time_final<br>";
            echo "Opponent's name: $opponentname<br>";
            echo "Opponent's time: $opponenttime<br>";
            if($opponenttime == -1)
            {
                echo "Congradulations!!! You've defeated your opponent in this game of wits!";
            }
            else if($opponenttime < $time_final)
            {
                echo "Too Bad! Your opponent has bested you!";
            }
            else if($opponenttime >= $time_final)
            {
                echo "Congradulations!!! You've defeated your opponent in this game of wits!";
            }
            
            
            if($user_time == -1)
            {
                $sql5 = "UPDATE accounts SET time=\"$time_final\" WHERE AID=\"$playerid\"";
                $retval2 = mysql_query($sql5);
            }
            else if($user_time > $time_final)
            {
                $sql5 = "UPDATE accounts SET time=\"$time_final\" WHERE AID=\"$playerid\"";
                $retval2 = mysql_query($sql5);
            }

        }
    }
    else
    {
    ?>
        <title>Time Attack!!</title>
            <a href="index.php"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
                <style>
                    html{ background-color:#CCE6FF;}
                    body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
                    p{text-align: center; font-size:25px;}
                    .option { text-decoration:none; color: #204081; width: 500px; text-align: center; border: 1px solid #9325BC; padding: 10px; position:absolute; left:0; right:0; margin:auto; font-size:25px; } 
                    .option:hover { -moz-box-shadow: 0 0 20px #ccc; -webkit-box-shadow: 0 0 20px #ccc; box-shadow: 0 0 10px #ccc; }
                </style>
    <?php
        $score = 0;
        //Takes the unix timestamp on first run and adds it to the session
        $time_start = microtime(true);
        $_SESSION['starttime'] = $time_start;
        echo "<br><br>Time start is set: $time_start";
        echo "<br>Please enter the username of the opponent you wish to face:<br>";
        //form used to take in opponent's username
        echo "<div> 

                <form method=\"post\" action=\"\" name=\"opponent\" id=\"opponent\">
                    <input type=\"text\" name=\"opponent\" id=\"opponent\" >
                    <input type=\"hidden\" name=\"score\" id=\"score\" value=\"$score\">
                    <input type=\"submit\" value=\"submit\" onclick=\"timedgame.php\">
                </form>
                </div> <br><br>";
        
    }
    ?>
    </body>  
</html>