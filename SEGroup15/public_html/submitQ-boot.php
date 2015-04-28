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
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    
    
    
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
              
            .center {
                text-align: center;
            }
    </style>
    
    <div class="container-fluid">
    <a href="index-boot.php">
      <img style="
        position: relative; 
        display: block; 
        margin: auto; 
        width: 35em; min-width: 30; 
        height: 6em; min-height: 4em;"
        color: rgba(46, 19, 178, 0); 
        src="logo.png" alt="T.R.I.V.I.A"></a>
    </div>

    <title>Question Submission </title>
</head>

<body>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    
    <!-- show content -->
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
        <div class="center">    
        <h3>Here you can submit your own questions to our servers! </h3><br> 
        <h5>Try entering a question, a correct answer, and 3 fake answers. </h5>
        </div>
    
    <div class="row">
        <div class="col-lg-offset-3 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Submit a Question</h5>
                </div>
                    <div class="panel-body">
                        <form method="post" action="" name="submitq" id="submitq">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Question:</label>
                                        <input class="form-control" type="text" name="question" id="question">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Correct Answer:</label>
                                        <input class="form-control" type="text" name="answer" id="answer">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Fake Answer:</label>
                                        <input class="form-control" type="text" name="fake1" id="fake1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Fake Answer:</label>
                                        <input class="form-control" type="text" name="fake2" id="fake2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Fake Answer:</label>
                                        <input class="form-control" type="text" name="fake3" id="fake3">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-buttons">
                                <a href="index-boot.php" class="btn btn-default">Back</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
    
            </div>
    
        </div>
    </div>
    </div>
</body>
</html>

