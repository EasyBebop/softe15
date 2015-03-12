<!DOCTYPE html>
<html>
    
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

//add questions if POST set
if(isset($_POST['question'])||isset($_POST['answer'])||isset($_POST['fake1'])||isset($_POST['fake2'])||isset($_POST['fake3']))
{	
	if(empty($_POST['question'])|| empty($_POST['answer']) || empty($_POST['fake1']) || empty($_POST['fake2'])|| empty($_POST['fake3']))
	{
		echo "Please fill in all fields to submit a question. <br>";
	}
        else
        {
             $sql = "INSERT INTO questions (Q,correct,fake1,fake2,fake3)
             VALUES ('$_POST[question]','$_POST[answer]','$_POST[fake1]','$_POST[fake2]','$_POST[fake3]')";
             $retval = mysql_query( $sql, $dbhandle );
             echo "Congratulations!  Your question was successfully submitted!";
        }   
}
?>

<head>
    <!--layout-->
    <a href="index.html"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
        <style>
            html{ background-color:#CCE6FF;}
            body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
            p{text-align: center; font-size:25px;}
            #form{margin-left:20px; font-size:20px;}
        </style>
    <title>T.R.I.V.I.A Question Submission </title>
</head>

<body>
    <!-- show content -->
    <img style="position:absolute; left:0; right:0; top:130px;  margin:auto;" src="navbar.png" alt="navbar" width="900" height="40">
    <a href="index.html"><img style="position:absolute; left:270px; top:135px;" src="home.png" alt="navbar" width="60" height="30"></a>
    <a href="createAccount.php"><img style="position:absolute; left:370px; top:135px;" src="createaccount.png" alt="navbar" width="180" height="30"></a>
    <a href="submitQ.php"><img style="position:absolute; left:590px; top:135px;" src="submitq.png" alt="navbar" width="180" height="30"></a><br><br>
    <p>Here you can submit your own questions to our servers! <br> Try entering a question, a correct answer, and 3 fake answers. </p>
    <p> You may see your question one day while playing! </P><br><br>
    <div id="form">
        <form method="post" action="" name="submitq" id="submitq"><br>
            Question: <input type="text" name="question" id="question" size="110"><br>
            Correct Answer: <input type="text" name="answer" id="answer" size="110"><br>
            Fake Answer: <input type="text" name="fake1" id="fake1" size="110"><br>
            Fake Answer: <input type="text" name="fake2" id="fake2" size="110"><br>
            Fake Answer: <input type="text" name="fake3" id="fake3" size="110"><br><br>
            <a href="index.html"><img style="position:relative; left:20px;" src="back.png" alt="back" width="60" height="50"></a>
            <input type="image" style="position:relative; left:200px;"  src="submit.png" alt="submit" width="80" height="50"> 
        </form>
     </div>
    
</body>
</html>

