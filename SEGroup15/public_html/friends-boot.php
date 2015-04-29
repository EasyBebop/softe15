
<?php
    session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    
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
    $activeChat = 11;
    $hash = 0;
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
        session_unset();
        session_destroy();
    }
    //check set chat
    if(isset($_POST['toSet']))
    {
        $key = 53;
        if(isset($_SESSION['username']))
        {
            global $activeChat, $hash;
            $tempHash1 = $_SESSION['id']+$key*$key;
            $tempHash2 = $_POST['toSet'] +$key*$key;
            $hash = $tempHash1 * $tempHash2;
            $hash = mysql_real_escape_string($hash);
            $activeChat = "chat".$hash;
            
            
            //select a database to work with
            $selected = mysql_select_db("chat",$dbhandle) 
             or die("Could not select chat");
            
            $sql = "CREATE TABLE IF NOT EXISTS `".$activeChat."` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, user text, msg text, dt date)";
            $retval = mysql_query( $sql, $dbhandle );
            if(! $retval )
            {
               die('Could not get data: ' . mysql_error());
            } 
        }
        //select a database to work with
        $selected = mysql_select_db("accounts",$dbhandle) 
         or die("Could not select examples");
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
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    
<script type="text/javascript">
// FUNCTIONS FOR CHAT

var t = setInterval(function(){get_chat_msg()},3000);

//
// General Ajax Call
//
      
var oxmlHttp;
var oxmlHttpSend;
      
function get_chat_msg()
{
    var url = "chat_recv_ajax.php";
    if(typeof XMLHttpRequest != "undefined")
    {
        oxmlHttp = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
       oxmlHttp = new ActiveXObject("Microsoft.XMLHttp");
    }
    if(oxmlHttp == null)
    {
        alert("Browser does not support XML Http Request");
       return;
    }
    
    url += "?chat=" + "<?php echo "$activeChat";?>";
    oxmlHttp.onreadystatechange = get_chat_msg_result;
    oxmlHttp.open("GET",url,true);
    oxmlHttp.send(null);
}
     
function get_chat_msg_result()
{
    if(oxmlHttp.readyState==4 || oxmlHttp.readyState=="complete")
    {
        if (document.getElementById("DIV_CHAT") != null)
        {
            document.getElementById("DIV_CHAT").innerHTML =  oxmlHttp.responseText;
            oxmlHttp = null;
        }
        var scrollDiv = document.getElementById("DIV_CHAT");
        scrollDiv.scrollTop = scrollDiv.scrollHeight;
    }
}
      
function set_chat_msg()
{
    if(typeof XMLHttpRequest != "undefined")
    {
        oxmlHttpSend = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
       oxmlHttpSend = new ActiveXObject("Microsoft.XMLHttp");
    }
    if(oxmlHttpSend == null)
    {
       alert("Browser does not support XML Http Request");
       return;
    }
    
    var url = "chat_send_ajax.php";
    var strname="noname";
    var strmsg="";
    if (document.getElementById("txtname") != null)
    {
        strname = document.getElementById("txtname").value;
        document.getElementById("txtname").readOnly=true;
    }
    if (document.getElementById("txtmsg") != null)
    {
        strmsg = document.getElementById("txtmsg").value;
        document.getElementById("txtmsg").value = "";
    }
    
    url += "?name=" + strname + "&msg=" + strmsg + "&chat=" + "<?php echo "$activeChat";?>";
    oxmlHttpSend.open("GET",url,true);
    oxmlHttpSend.send(null);
}

function handleKeyPress(e){
 var key=e.keyCode || e.which;
  if (key==13)
  {
     set_chat_msg();
  }
}
</script>




<!--------------------layout-------------------->    
    <style> 
            .accountInfo {
              position: fixed; 
              top: -.5em; 
              margin-left: .5em; 
              color: rgba(41, 178, 38, 1); }

            #friendText {
              position:relative;
              
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
    <title>T.R.I.V.I.A Friends Page </title>
    <a href="index-boot.php">
      <img style="
        position:relative; 
        display:block; 
        margin: auto; 
        width: 35em; min-width: 30; 
        height: 6em; min-height: 4em;"
        color: rgba(46, 19, 178, 0); 
        src="logo.png" alt="T.R.I.V.I.A"></a>   
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
        
        
    <?php
    if(isset($_SESSION['username']))
    {
        echo "<p id='friendText'><strong>Friends: </strong></p>";
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
                    echo "<form method=\"POST\"action=\"friends-boot.php\"name=\"setChat\" id=\"setChat\">";
                    echo "<input type=\"hidden\" value=\"$row[AID]\" name=\"toSet\" id=\"toSet\">";
                    echo "<br><input type=\"submit\" class=\"btn btn-default\" value=\"$row[username]\"><br>";
                    echo "</form>";
                    
                    
                }
            }
        }
 
        echo "<div id=\"form\">";
        echo "<form method=\"post\" action=\"friends-boot.php\" name=\"addFriend\" id=\"addFriend\"><br>";
        echo "Enter friend's username: <input type=\"text\" name=\"add\" id=\"add\" size=\"20\"><br>";
        echo "<button type=\"submit\" class=\"btn btn-default\">Submit</button> ";
        echo "</form></div>";
    }
    else
    {
        echo"<div style=\"text-align:center\"><h5> You must be signed in to view friends.<\h5></div>";
    }
    ?>
 
   <!-- TABLE FOR CHAT DISPLAY -->
   <div class="container-fluid">
       <div class="col-lg-offset-3 col-xs-12 col-sm-12 col-md-8 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 style="color:blue">Chat</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                           <td colspan="2" style="font-weight: bold; font-size: 16pt; color: blue; font-family: verdana, arial;
                            text-align: left">
                                <table style="font-size: 12pt; color: black; font-family: Verdana, Arial">
                                    <tr>
                                        <td style="width: 100px">
                                            Name:</td>
                                        <td style="width: 100px"><input id="txtname" style="width: 150px" type="text" name="name" value="<?php echo "$user";?>" maxlength="15" /></td>
                                    </tr>
                                </table>
                            </td> 
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;" valign="middle" colspan="2">
                                <div style="width: 480px; height: 400px; border-right: darkslategray thin solid; border-top: darkslategray thin solid; font-size: 10pt; border-left: darkslategray thin solid; border-bottom: darkslategray thin solid; font-family: verdana, arial; overflow:scroll; text-align: left;" id="DIV_CHAT">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 310px">
                                <input id="txtmsg" style="width: 350px" type="text" name="msg" />
                            </td>
                            <td style="width: 85px">
                                <input id="Submit2" class="btn btn-default" style="font-family: verdana, arial" type="button" value="Send" onclick="set_chat_msg()" onKeyPress="handleKeyPress(event)"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="font-family: verdana, arial; text-align: center; width: 350px;">
                            </td>
                            <td colspan="1" style="width: 85px; font-family: verdana, arial; text-align: center">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
       </div>
    </div>      
    </div>
</body>
</html>