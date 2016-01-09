<?php 
  session_start(); 
  
  if(!isset($_SESSION["phase1done"]) || $_SESSION["phase1done"] !== "true") {

?>
<h1>Uh oh! You need to finish <a href="phase1.php">Phase 1</a> before proceeding to Phase 4.</h1>
<?php
    die();
  }

  if(!isset($_SESSION["phase2done"]) || $_SESSION["phase2done"] !== "true" ) {
?>
<h1>Uh oh! You need to finish <a href="phase2.php">Phase 2</a> before proceeding to Phase 4.</h1>
<?php
    die();
  }

  if(!isset($_SESSION["phase3done"]) || $_SESSION["phase3done"] !== "true" ) {
?>
<h1>Uh oh! You need to finish <a href="phase3.php">Phase 3</a> before proceeding to Phase 4.</h1>
<?php
    die();
  }
  
  $warn = $notice = 0;  
?><h1>SQL Injection Project - Phase 4</h1>
Your goal in this phase of the project is to try out various sets of strings to narrow down on one that will break <b><u>both</u></b> the SQL Statements given below:
<br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable2 WHERE itemname = '&lt;?php echo $_POST["form_itemname"]; ?&gt;';
</code><br /><br /><code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable2 WHERE itemname = "&lt;?php echo $_POST["form_itemname"]; ?&gt;";
</code>
<br /><br />
When we run that query, we will list all the matching results. Your aim is to list all the records of the table <b>sampletable2</b> when both the queries are executed.
<br />If you want to see all rows of table <b>sampletable2</b>, visit <a href="pahse2.php">phase 2</a> and put the following the text box:<br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
1 OR 1 = 1
</code>
<br /><br />
<?php
  if(!isset($_SESSION["phase4count"])) {
    echo "Welcome to <b>Phase 4</b>!";
    $_SESSION["phase4count"] = "0"; 
    $_SESSION["phase4done"] = "false";
  } else {
    $_SESSION["phase4count"] = strval(intval($_SESSION["phase4count"]) + 1);
    echo "You've viewed this <b>{$_SESSION["phase4count"]} time(s)</b>!";
  }
?>
<br /><br />
<form method="POST">
  <input type="text" name="form_itemname" style="width:500px" />
  <br />
  <input type="submit" value="Crack open the secrets..." />
</form>
<br />
<?php
  function checkdone() {
    if($_SESSION["phase4done"] === "true") {
?>
<br />
<div style="font-size: 1.3em">
  You seem to have previously hacked into this phase as well!<br />
  Click <a href="phase5.php">here</a> to proceed to Phase 5.
</div>
<?php
    }
  }

  if(isset($_POST["form_itemname"])){	  
?>
Your last two attempts executed the following on our MySQL Server:<br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable2 WHERE itemname = '<?php echo $_POST["form_itemname"]; ?>';
</code><br /><br />
<code style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid">
SELECT * FROM sampletable2 WHERE itemname = "<?php echo $_POST["form_itemname"]; ?>";
</code>
<br /><br />
<?php
  // Execute on the server now
  $uname = "root"; $passwd = "cs2000aa"; $host = "localhost";
?>
On executing the MySQL Statement on our server, the following was the output:<br />
<div style="background: #ae8; padding: 5px; margin: 10px; border: 1px black solid; font-family: DejaVu Sans Mono; font-size: 14.4px">
<?php
  $error1 = false; $error2 = false;

  $dbhandle = mysql_connect($host, $uname, $passwd) or die("Unable to connect to MySQL Database!</div>");
  echo "Established connection with the MySQL Database!<br />";
  $selected = mysql_select_db("testdb", $dbhandle) or die("Unable to choose MySQL Database!</div>");
  echo "Chose the required database.<br />";
  $queryString = "SELECT * FROM sampletable2 WHERE itemname = '{$_POST["form_itemname"]}';";
  $result1 = mysql_query($queryString) or ($error1 = true);
  $queryString = "SELECT * FROM sampletable2 WHERE itemname = \"{$_POST["form_itemname"]}\";";
  $result2 = mysql_query($queryString) or ($error2 = true);
  mysql_close($dbhandle);
  echo "Closed the database connection successfully!<br />";
?>
</div>
<br /><br />
<table style="width:100%">
<tr><th style="width:50%">Records fetched by Query 1</th>
<th style="width:50%">Records fetched by Query 2</th></tr>
<tr><td style="width:50%">
<?php
    if(!$error1) {
      $count1 = 0;
      // Iterate through now
      while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {
        if($count1 == 0) {
?>
<center><table><tr><th>itemid</th><th>itemname</th><th>itemquantity</th></tr>
<?php
        }
        $count1++;
?>
<tr><td><center><?= $row["itemid"]; ?></center></td><td><center><?= $row["itemname"]; ?></center></td><td><center><?= $row["itemquantity"]; ?></center></td></tr>
<?php
      }
      if($count1 != 0) {
?>
</table>
<?php
      }
      // If none fetched, warn:
      if($count1 == 0) {
?>
<br />
<center><h3>No records were fetched!</h3></center>
<?php
      }
    } else {
?>
<br />
<center><h3>Error fetching records for Query 1</h3></center>
<?php
    }
?>
</td><td style="width:50%">
<?php
    if(!$error2) {
      $count2 = 0;
      // Iterate through now
      while ($row = mysql_fetch_array($result2, MYSQL_ASSOC)) {
        if($count2 == 0) {
?>
<br />
<center><table><tr><th>itemid</th><th>itemname</th><th>itemquantity</th></tr>
<?php
        }
        $count2++;
?>
<tr><td><center><?= $row["itemid"]; ?></center></td><td><center><?= $row["itemname"]; ?></center></td><td><center><?= $row["itemquantity"]; ?></center></td></tr>
<?php
      }
      if($count2 != 0) {
?>
</table>
<?php
      }
      // If none fetched, warn:
      if($count2 == 0) {
?>
<br />
<center><h3>No records were fetched!</h3></center>
<?php
      }
    } else {
?>
<br />
<center><h3>Error fetching records for Query 2</h3></center>
<?php
    }
?>
</td></tr></table>
<?php
    // Check for Phase 5
    if($count1 == 10 && $count2 == 10) {
      $_SESSION["phase4done"] = "true";
?>
<br /><div style="font-size:1.3em">
  Phew! You got done with Phase 4 as well!<br />
  Proceed to Phase 5 <a href="phase5.php">here</a>.
</div>
<?php
      die();
    }
    checkdone();
  } else {
    checkdone();
  }
?>
