<?php

     require_once('dbconnect.php');

     db_connect();

     $msg = $_GET["msg"];
     $dt = date("Y-m-d H:i:s");
     $user = $_GET["name"];
     $chat = $_GET["chat"];
     $chat = mysql_real_escape_string($chat);

     $sql="INSERT INTO ".$chat." (user,msg,dt) " .
          "values(" . quote($user) . "," . quote($msg) . "," . quote($dt) . ");";

          echo $sql;

     $result = mysql_query($sql);
     if(!$result)
     {
        throw new Exception('Query failed: ' . mysql_error());
        exit();
     }

?>





