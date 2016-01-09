<?php 
  session_start(); 
  $warn = $notice = 0;  
?><h1>SQL Injection Project - Phase 1</h1>
Your goal in this phase of the project is to try out various sets of strings to narrow down on one that will break the SQL Statement given below:
<br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable1 WHERE identification = '&lt;?php echo $_POST["form_identi"]; ?&gt;';
</code>
<br /><br />
<?php
  if(!isset($_SESSION["phase1count"])) {
    echo "Welcome to <b>Phase 1</b>!";
    $_SESSION["phase1count"] = "0"; 
    $_SESSION["phase1done"] = "false";
  } else {
    $_SESSION["phase1count"] = strval(intval($_SESSION["phase1count"]) + 1);
    echo "You've viewed this <b>{$_SESSION["phase1count"]} time(s)</b>!";
  }
?>
<br /><br />
<form method="POST">
  <input type="text" name="form_identi" style="width:500px" />
  <br />
  <input type="submit" value="Lets start hacking! :D" />
</form>
<br />
<?php
  function checkdone() {
    if($_SESSION["phase1done"] === "true") {
?>
<br />
<div style="font-size: 1.3em">
  You seem to be done with this phase!<br />
  Click <a href="phase2.php">here</a> to proceed to Phase 2.
</div>
<?php
    }
  }

  if(isset($_POST["form_identi"])){	  
?>
Your last attempt executed the following on our MySQL Server:<br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable1 WHERE identification = '<?php echo $_POST["form_identi"]; ?>';
</code>
<br /><br />
<?php
  // Execute on the server now
  $uname = "root"; $passwd = "cs2000aa"; $host = "localhost";
?>
On executing the MySQL Statement on our server, the following was the output:<br /><br />
<div style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid; font-family: DejaVu Sans Mono; font-size: 14.4px">
<?php

  function dierror($dbhandle) {
    if(strpos(mysql_error(), "right syntax to use near '") !== false) {
      $_SESSION["phase1done"] = "true";
      echo mysql_error() . "<br /></div><br />";
?>
<div style="font-size: 1.3em">
  Well done! :)<br />
  Proceed to Phase 2 by clicking <a href="phase2.php">here</a>
</div>
<?php
      mysql_close($dbhandle);
      die();
    } else {
      echo mysql_error() . "<br /></div>";
    }
    mysql_close($dbhandle);
    checkdone();
    die();
  }

  $dbhandle = mysql_connect($host, $uname, $passwd) or die("Unable to connect to MySQL Database!</div>");
  echo "Established connection with the MySQL Database!<br />";
  $selected = mysql_select_db("testdb", $dbhandle) or die("Unable to choose MySQL Database!</div>");
  echo "Chose the required database.<br />";
  $queryString = "SELECT * FROM sampletable1 WHERE identification = '{$_POST["form_identi"]}'";
  $result = mysql_query($queryString) or dierror($dbhandle); 
  mysql_close($dbhandle);
  echo "Closed the database connection successfully!<br />";
?>
</div>
<?php
  checkdone();
  } else {
    checkdone();
  }
?>
