<?php 
  session_start(); 
  
  if(!isset($_SESSION["phase1done"]) || $_SESSION["phase1done"] !== "true") {

?>
<h1>Uh oh! You need to finish <a href="phase1.php">Phase 1</a> before proceeding to Phase 5.</h1>
<?php
    die();
  }

  if(!isset($_SESSION["phase2done"]) || $_SESSION["phase2done"] !== "true" ) {
?>
<h1>Uh oh! You need to finish <a href="phase2.php">Phase 2</a> before proceeding to Phase 5.</h1>
<?php
    die();
  }

  if(!isset($_SESSION["phase3done"]) || $_SESSION["phase3done"] !== "true" ) {
?>
<h1>Uh oh! You need to finish <a href="phase3.php">Phase 3</a> before proceeding to Phase 5.</h1>
<?php
    die();
  }

  if(!isset($_SESSION["phase4done"]) || $_SESSION["phase4done"] !== "true" ) {
?>
<h1>Uh oh! You need to finish <a href="phase4.php">Phase 4</a> before proceeding to Phase 5.</h1>
<?php
    die();
  }

  $warn = $notice = 0;  
?><h1>SQL Injection Project - Phase 5</h1>
Your goal in this phase of the project is to show the below hash for the grader to ensure you get full credit for doing this ISP Project:
<br />
<center><h3>81eb4286e9ada4dd9b58c53f16e8c404</h3></center>
<b>NOTE TO GRADERS: </b> Please check the entire hash before giving the grade to the student!
