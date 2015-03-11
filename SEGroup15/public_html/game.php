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
    echo "Connected to MySQL<br>";

    //select a database to work with
    $selected = mysql_select_db("questions",$dbhandle) 
    or die("Could not select examples");
    
    //get number of questions available
    $result1 = mysql_query("select count(1) FROM questions");
    $numRow = mysql_fetch_array($result1);
    $numOfQuestions = $numRow[0];
    
    //generate random question
    $random = mt_rand(1,$numOfQuestions);
    
    $sql = "SELECT * FROM questions WHERE QID = $random";
    $result2 = mysql_query($sql);
    
        $row = mysql_fetch_array($result2) or die(mysql_error());  
//        $option1 = $row['correct'];
//        $option2 = $row['fake1'];
//        $option3 = $row['fake2'];
//        $option4 = $row['fake3'];
        $question = $row['Q'];
        $options = array("$row[correct]","$row[fake1]","$row[fake2]","$row[fake3]");
        shuffle($options);
    
    ?>
        
        <title>Playing a game</title>
        <a href="index.html"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
         <style>
            html{ background-color:#CCE6FF;}
            body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
            p{text-align: center; font-size:25px;}
            .option { text-decoration:none; color: #204081; width: 500px; text-align: center; border: 1px solid #9325BC; padding: 10px; position:absolute; left:0; right:0; margin:auto; font-size:25px; } 
            .option:hover { -moz-box-shadow: 0 0 20px #ccc; -webkit-box-shadow: 0 0 20px #ccc; box-shadow: 0 0 10px #ccc; }
         </style>
    </head>
    <body>
        <img style="position:absolute; left:0; right:0; top:130px;  margin:auto;" src="navbar.png" alt="navbar" width="900" height="40">
        
        
        
        <!-- question -->
        <br><p> <?php echo $question ?> <p>
        
        <!-- options -->  
        <?php
        for( $i = 0; $i < sizeof($options); $i++)
        {
             echo "<div> 
            <form method=\"post\" action=\"\" name=\"option$i\" id=\"option$i\">
                <br><br><br>
                <a class=\"option\" href=\"#\" onclick=\"document.option$i.submit();\">$options[$i]</a> 
            </form>
            </div> <br><br>";
        }
        ?>
   
        
    </body>
    
</html>