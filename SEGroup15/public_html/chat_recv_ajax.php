<?php

     require_once('dbconnect.php');

     db_connect();
     
     $chat = $_GET["chat"];
     $chat = mysql_real_escape_string($chat);
     
     $sql = "SELECT *, date_format(dt,'%d-%m-%Y %r') as cdt from `".$chat."` order by ID desc limit 200";
     $sql = "SELECT * FROM (" . $sql . ") as ch order by ID";
     $result = mysql_query($sql);
     
     // Update Row Information
     $msg="<table border='0' style='font-size: 10pt; color: blue; font-family: verdana, arial;'>";
     while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
     {
           $msg = $msg . "<tr><td>" . $line["dt"] . "&nbsp;</td>" .
                "<td>" . $line["user"] . ":&nbsp;</td>" .
                "<td>" . $line["msg"] . "</td></tr>";
     }
     $msg=$msg . "</table>";
     
     echo $msg;

?>





