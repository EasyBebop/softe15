
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
$selected = mysql_select_db("accounts",$dbhandle) 
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
        $friends = $_SESSION['friends'];
    }
    //logout function
    function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }

//add friends
    if(isset($_POST['add']))
    {
        if(empty($_POST['add']))
            {
                    echo "<br>Please fill in the field <br>";
            }
        else
        {
            $sql = 'SELECT AID, username, pass, friends FROM accounts';

            $retval = mysql_query( $sql, $dbhandle );
            if(! $retval )
            {
               die('Could not get data: ' . mysql_error());
            }
                
            // loop and search in accounts
            $accountFound = false;
            while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
            {
                if($_POST['add'] == $row['username'])
                {
                    $accountFound = true;
                    $add = $row['AID'];
                    $friendsToAdd = $friends.",".$add;
                    $sql2 = "UPDATE accounts SET friends=\"$friendsToAdd\" WHERE AID=$_SESSION[id]";
                    $retval2 = mysql_query( $sql2, $dbhandle );
                    $friends = $friendsToAdd;
                    $_SESSION['friends'] = $friends;
                    echo "<br>Friend added successfully";
                    break;
                }
            }
            if($accountFound == false)
            {
                echo "<br>Account does not exist";
            }
        }
    }

    
?>

<head>
    <!--layout-->
    <a href="index.php"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
        <style>
            html{ background-color:#CCE6FF;}
            body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
            p{text-align: center; font-size:25px;}
            #form{margin-left:20px; font-size:20px;}
        </style>
    <title>T.R.I.V.I.A Friends Page </title>
</head>

<body>
    <!-- show content -->
    <div class="accountInfo">
        <br> Currently logged in as <?php echo $user;
        if(isset($_SESSION['username']))
        {
        echo "<div id=\"logoutButton\">";
            echo "<form method=\"post\" action=\"index.php\" name=\"logout\" id=\"logout\">";
                echo "<input type=\"submit\" value=\"Logout\" name=\"logoutOrder\">";
            echo "</form>";
        echo "</div>";
        }        
        ?>        
    </div>
    
    <img style="position:absolute; left:0; right:0; top:130px;  margin:auto;" src="navbar.png" alt="navbar" width="900" height="40">
    <a href="index.php"><img style="position:absolute; left:270px; top:135px;" src="home.png" alt="navbar" width="60" height="30"></a>
    <a href="createAccount.php"><img style="position:absolute; left:370px; top:135px;" src="createaccount.png" alt="navbar" width="180" height="30"></a>
    <a href="submitQ.php"><img style="position:absolute; left:590px; top:135px;" src="submitq.png" alt="navbar" width="180" height="30"></a><br><br>
    
    <?php
    if(isset($_SESSION['username']))
    {
        echo "<p>List of friends! </p>";
        //friends
        $tempFriends = explode(',', $friends);
        for($i = 1; $i<sizeof($tempFriends);$i++)
        {   
            $sql = 'SELECT AID, username, pass, friends FROM accounts';
            $retval = mysql_query( $sql, $dbhandle );
            if(! $retval )
            {
               die('Could not get data: ' . mysql_error());
            }
            while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
            {
                if($tempFriends[$i] == $row['AID'])
                {
                    
                    echo "<br>$row[username]<br>";
                }
            }
        }
 
        
        
        echo "<div id=\"form\">";
        echo "<form method=\"post\" action=\"friends.php\" name=\"addFriend\" id=\"addFriend\"><br>";
        echo "Enter friend's username: <input type=\"text\" name=\"add\" id=\"add\" size=\"20\"><br>";
        echo "<input type=\"image\" style=\"position:relative; left:20px;\"  src=\"submit.png\" alt=\"submit\" width=\"70\" height=\"43\"> ";
        echo "</form></div>";
    }
    else
    {
        echo"<p> You must be signed in to have friends";
    }
    ?>
    
</body>
</html>