<?php
    session_start();
?>

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
              
            #form {
              position: relative;
              text-align: center;
              width: 80em;
              height: 100%;
              padding: 0px; }
    </style>
    
    <a href="index.php">
      <img style="
        position: relative; 
        display: block; 
        margin: auto; 
        width: 35em; min-width: 30; 
        height: 6em; min-height: 4em;"
        color: rgba(46, 19, 178, 0); 
        src="logo.png" alt="T.R.I.V.I.A"></a>
        
    <title>T.R.I.V.I.A Question Submission </title>
</head>

<body>
    <!-- show content -->
    <div class="accountInfo">
        <br> Currently logged in as <strong><?php echo $user;
        if(isset($_SESSION['username']))
        {
        echo "<div id=\"logoutButton\">";
            echo "<form method=\"post\" action=\"index.php\" name=\"logout\" id=\"logout\">";
                echo "<input type=\"submit\" value=\"Logout\" name=\"logoutOrder\">";
            echo "</form>";
        echo "</div>";
        }        
        ?></strong>        
    </div>
    
    <img style="position:absolute; left:0; right:0; top:5em; margin:auto;" src="navbar.png" alt="navbar" width="70%" height="5%">
        
        <a href="index.php">
          <img style="
            position:absolute; 
            left:17%; 
            top:5.2em;" 
            src="home.png" alt="navbar" width="5%" height="4%"></a>
        
        <a href="createAccount.php">
          <img style="
            position:absolute; 
            left:27%; 
            top:5.2em; 
            color: rgba(41, 178, 38, 0);" 
            src="createaccount.png" alt="navbar" width="10%" height="4%"></a>
        
        <a href="submitQ.php">
          <img style="
            position:absolute; 
            left:42%; 
            top:5.2em; 
            color: rgba(41, 178, 38, 0);" 
            src="submitq.png" alt="navbar" width="10%" height="4%"></a>
        
        <a href="friends.php">
          <img style="
            position:absolute; 
            left:57%; 
            top:5.2em; 
            color: rgba(41, 178, 38, 0);" 
            src="friends.png" alt="navbar" width="10%" height="4%"></a>
            
    <p>Here you can submit your own questions to our servers! <br> Try entering a question, a correct answer, and 3 fake answers. </p>
    <p> You may see your question one day while playing! </p><br><br>
    <div id="form">
        <form method="post" action="" name="submitq" id="submitq"><br>
            Question: <input type="text" name="question" id="question" size="110"><br><br>
            Correct Answer: <input type="text" name="answer" id="answer" size="110"><br><br>
            Fake Answer: <input type="text" name="fake1" id="fake1" size="110"><br><br>
            Fake Answer: <input type="text" name="fake2" id="fake2" size="110"><br><br>
            Fake Answer: <input type="text" name="fake3" id="fake3" size="110"><br><br>
            <a href="index.php"><img style="position:relative; left: -2em;" src="back.png" alt="back" width="50" height="40"></a>
            <input type="image" style="position:relative; left: 2.5em;"  src="submit.png" alt="submit" width="50" height="40"> 
        </form>
     </div>
    
</body>
</html>

