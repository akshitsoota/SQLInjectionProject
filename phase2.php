<?php 
  session_start(); 
  
  if(!isset($_SESSION["phase1done"]) || $_SESSION["phase1done"] !== "true" ) {

?>
<h1>Uh oh! You need to finish <a href="phase1.php">Phase 1</a> before proceeding to Phase 2.</h1>
<?php
    die();
  }

  $warn = $notice = 0;  
?><h1>SQL Injection Project - Phase 2</h1>
Your goal in this phase of the project is to try out various sets of strings to narrow down on one that will break the SQL Statement given below:
<br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable2 WHERE itemid = &lt;?php echo $_POST["form_itemid"]; ?&gt;;
</code>
<br /><br />
When we run that query, we will list all the matching results. Your aim is to list all the records of the table <b>sampletable2</b>.
<br /><br />
<?php
  if(!isset($_SESSION["phase2count"])) {
    echo "Welcome to <b>Phase 2</b>!";
    $_SESSION["phase2count"] = "0"; 
    $_SESSION["phase2done"] = "false";
  } else {
    $_SESSION["phase2count"] = strval(intval($_SESSION["phase2count"]) + 1);
    echo "You've viewed this <b>{$_SESSION["phase2count"]} time(s)</b>!";
  }
?>
<br /><br />
<form method="POST">
  <input type="text" name="form_itemid" style="width:500px" />
  <br />
  <input type="submit" value="Proceed with the hacking session" />
</form>
<br />
<?php
  function checkdone() {
    if($_SESSION["phase2done"] === "true") {
?>
<br />
<div style="font-size: 1.3em">
  You seem to have previously hacked into this phase as well!<br />
  Click <a href="phase3.php">here</a> to proceed to Phase 3.
</div>
<?php
    }
  }

  if(isset($_POST["form_itemid"])){	  
?>
Your last attempt executed the following on our MySQL Server:<br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable2 WHERE itemid = <?php echo $_POST["form_itemid"]; ?>;
</code>
<br /><br />
<?php
  // Execute on the server now
  $uname = "root"; $passwd = "cs2000aa"; $host = "localhost";
?>
On executing the MySQL Statement on our server, the following was the output:<br />
<div style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid; font-family: DejaVu Sans Mono; font-size: 14.4px">
<?php
  $dbhandle = mysql_connect($host, $uname, $passwd) or die("Unable to connect to MySQL Database!</div>");
  echo "Established connection with the MySQL Database!<br />";
  $selected = mysql_select_db("testdb", $dbhandle) or die("Unable to choose MySQL Database!</div>");
  echo "Chose the required database.<br />";
  $queryString = "SELECT * FROM sampletable2 WHERE itemid = {$_POST["form_itemid"]}";
  $result = mysql_query($queryString) or die(mysql_error() . "\n</div>"); 
  mysql_close($dbhandle);
  echo "Closed the database connection successfully!<br />";
?>
</div>
<?php
    $count = 0;
    // Iterate through now
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      if($count == 0) {
?>
<br />
<center><table style="width:25%"><tr><th>itemid</th><th>itemname</th><th>itemquantity</th></tr>
<?php
      }
      $count++;
?>
<tr><td><center><?= $row["itemid"]; ?></center></td><td><center><?= $row["itemname"]; ?></center></td><td><center><?= $row["itemquantity"]; ?></center></td></tr>
<?php
    }
    if($count != 0) {
?>
</table></center>
<?php
    }
    // Check if fetched all
    if($count == 10) {
      $_SESSION["phase2done"] = "true";
?>
<br />
<div style="font-size:1.3em">
  You nailed Phase 2!<br />
  Give Phase 3 a shot <a href="phase3.php">here</a>
</div>
<?php
      die();
    }
    // If none fetched, warn:
    if($count == 0) {
?>
<br />
<center><h3>No records were fetched!</h3></center>
<?php
    }
    checkdone();
  } else {
    checkdone();
  }
?>
