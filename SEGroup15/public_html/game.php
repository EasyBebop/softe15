<!DOCTYPE HTML>
<html>
    
    <head>
        <title>Playing a game</title>
        <a href="index.html"><img style="position:absolute; left:0; right:0; top:-30px; margin:auto;" src="logo.png" alt="T.R.I.V.I.A" width="300" height="200"></a>
         <style>
            html{ background-color:#CCE6FF;}
            body{ margin-left:250px; margin-right:250px;margin-top:150px; margin-bottom:130px; background-color: white; height:900px;}
            p{text-align: center; font-size:25px;}
         </style>
    </head>
    <body>
         <?php
            $score = 0;
            $question = NULL;
            $correct = NULL;
            $false1 = NULL;
            $false2 = NULL;
            $false3 = NULL;
        {
        ?>
        <h1>Future location for single player</h1>
        <form id="answerForm" method="post">
        <output type="text" id="q" name="question" value="<?php echo $question ?>">
	<input type="text" id="a1" name="answer1">
	<input type="text" id="a2" name="answer2">
	<input type="text" id="a3" name="answer3">
        <input type="text" id="a4" name="answer4"><form id="answerForm" method="post">
        <output type="text" id="q" name="question" value="<?php echo $question ?>">
	<input type="text" id="a1" name="answer1">
	<input type="text" id="a2" name="answer2">
	<input type="text" id="a3" name="answer3">
        <input type="text" id="a4" name="answer4">
	</form>

        <?php
        }
        ?>
    </body>
    
</html>