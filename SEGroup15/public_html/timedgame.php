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
        $score = $_POST[score];
    }
    else
    {
        $score = 0; 
    }
    
    //check num of questions that have been answered
    if(isset($_POST['questiontotal']))
    {
        $questiontotal = $_POST[questiontotal];
    }
    else
    {
        $questiontotal = 0;
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
    ?>
    </head>
    
    <body>
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