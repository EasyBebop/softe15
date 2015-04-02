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
    
    $seenArr = array();
    $seen = '';
    $seenPost = '';
    $newQ = false;
    
    //check for already seen questions
    if(isset($_POST['seenArr']))
    {
        foreach($_POST['seenArr'] as $seenPost)
        {
            $seenArr[] = $seen;
        }
    }
    else
    {
        $seenArr = ' ';
    }
    
    //get number of questions available
    $result1 = mysql_query("select count(1) FROM questions");
    $numRow = mysql_fetch_array($result1);
    $numOfQuestions = $numRow[0];
    
    //generate random question
    while($newQ == false)
    {
        $random = mt_rand(1,$numOfQuestions);
        foreach ($seenArray as $seen)
        {
            if($random != $seen)
            {
                $newQ = true;
            }
            else
            {
                $newQ = false;
            }
        }
    }
    
    $sql = "SELECT * FROM questions WHERE QID = $random";
    $result2 = mysql_query($sql);
    $row = mysql_fetch_array($result2) or die(mysql_error());  
    $question = $row['Q'];
    $questionID = $row['QID'];
    $options = array("$row[correct]","$row[fake1]","$row[fake2]","$row[fake3]");
    shuffle($options);
    ?>
        
    <!--layout-->    
    <title>Playing a game</title>
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
                echo "<script type='text/javascript'>alert(\"GOOD! Correct answer\");</script>";            
                $score = $score + 10;          
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
                <input type=\"hidden\" name=\"seen\" id=\"seen\" value=\"\">
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