<?php 
  session_start(); 
  
  if(!isset($_SESSION["phase1done"]) || $_SESSION["phase1done"] !== "true") {

?>
<h1>Uh oh! You need to finish <a href="phase1.php">Phase 1</a> before proceeding to Phase 3.</h1>
<?php
    die();
  }

  if(!isset($_SESSION["phase2done"]) || $_SESSION["phase2done"] !== "true" ) {
?>
<h1>Uh oh! You need to finish <a href="phase2.php">Phase 2</a> before proceeding to Phase 3.</h1>
<?php
    die();
  }

  $warn = $notice = 0;  
?><h1>SQL Injection Project - Phase 3</h1>
Your goal in this phase of the project is to try out various sets of strings to narrow down on one that will break the SQL Statement given below:
<br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable2 WHERE itemid = &lt;?php echo $_POST["form_itemid"]; ?&gt; AND itemname = "Sample Item A";
</code>
<br /><br />
When we run that query, we will list all the matching results. Your aim is to list one record of the table <b>sampletable2</b> with <b>itemid</b> equal to <b>1005</b>.
<br /><br />
<?php
  if(!isset($_SESSION["phase3count"])) {
    echo "Welcome to <b>Phase 3</b>!";
    $_SESSION["phase3count"] = "0"; 
    $_SESSION["phase3done"] = "false";
  } else {
    $_SESSION["phase3count"] = strval(intval($_SESSION["phase3count"]) + 1);
    echo "You've viewed this <b>{$_SESSION["phase3count"]} time(s)</b>!";
  }
?>
<br /><br />
<form method="POST">
  <input type="text" name="form_itemid" style="width:500px" />
  <br />
  <input type="submit" value="Inject it!" />
</form>
<br />
<?php
  function checkdone() {
    if($_SESSION["phase3done"] === "true") {
?>
<br />
<div style="font-size: 1.3em">
  Darn it! You previously broke into this phase as well!<br />
  Click <a href="phase4.php">here</a> to proceed to Phase 4.
</div>
<?php
    }
  }

  if(isset($_POST["form_itemid"])){	  
?>
Your last attempt executed the following on our MySQL Server:<br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable2 WHERE itemid = <?php echo $_POST["form_itemid"]; ?> AND itemname = "Sample Item A";
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
  $queryString = "SELECT * FROM sampletable2 WHERE itemid = {$_POST["form_itemid"]} AND itemname = \"Sample Item A\";";
  $result = mysql_query($queryString) or die(mysql_error() . "\n</div>"); 
  mysql_close($dbhandle);
  echo "Closed the database connection successfully!<br />";
?>
</div>
<?php
    $count = 0; $itemidfound = false;
    // Iterate through now
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      if($count == 0) {
?>
<br />
<center><table style="width:25%"><tr><th>itemid</th><th>itemname</th><th>itemquantity</th></tr>
<?php
      }
      $count++;
      if(($row["itemid"] == 1005 || $row["itemid"] == "1005") && $row["itemname"] == "Sample Item E") $itemidfound = true;
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
    if($count == 1 && $itemidfound == true) {
      $_SESSION["phase3done"] = "true";
?>
<br />
<div style="font-size:1.3em">
  You nailed Phase 3!<br />
  Give Phase 4 a shot <a href="phase4.php">here</a>
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
