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
                //Function used to submit time and answer form
                function clockStop($i){
                    $playertime->stop();
                    $_SESSION['time'] = $playertime->getElapsedTime(HRTime\Unit::SECOND);
                    $i.submit();
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
                        <br><br><br>
                        <a class=\"option\" href=\"#\" onclick=\"document.option$i.submit();\">$options[$i]</a> 
                    </form>
                    </div> <br><br>";
                }
        }
        else{
            //Pulls opponent's time from database and checks it against player time
            $opponentname = $_POST['opponent'];
            $opponenettime = mysql_query("select time from accouts where username = $opponentname");
            $time_finish = microtime(true);
            $time_final = $time_finish - $_SESSION['starttime'];
            echo "You made it this far<br>";
            echo "End Time: $time_final<br>";
            echo "Opponent's name: $opponentname";
            /*if($opponenttime >= $time_final)
            {

            }
            else if($opponenttime < $time_final)
            {

            }*/

        }
    }
    else
    {
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