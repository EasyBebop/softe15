<?php
    session_start();
?>

<!DOCTYPE html>

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
    }
    //logout function
    function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }
?>    

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
              left: 37.5em;
              right: 37.5em;
              width: 10.8em;
              height: 55%;
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
        
        <meta charset="UTF-8">
        <title>T.R.I.V.I.A Create an Account </title>
    </head>
   <body>
    <!--show content-->
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
     </body>
</html>