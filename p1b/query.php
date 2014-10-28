<DOCTYPE html>
<html>
<title> CS143 Project 1b </title>
<body>
<h1>Type an SQL query in the following box</h1>

<?php
?>

<form action="query.php" method="GET">
<textarea name="query" rows="5" cols="40"><?php echo $_GET["query"];?></textarea><br>
<input type = "submit" name = "submit">
<input type = "reset" name = "reset">
</form>

<?php
  function connectDB()
  {
    $db_connection = mysql_connect("localhost","cs143", "");
    mysql_select_db("TEST", $db_connection);
    return $db_connection;
  }

  function execute_command()
  {
    $db_connection = connectDB();
    $user_query = $_GET["query"];
    $sanitized_name = mysql_real_escape_string($user_query, $db_connection);
    $rs = mysql_query($sanitized_name, $db_connection);

    print "<h3>Results from MySQL:</h3>";
    print "<table border=1 cellspacing=1 cellpadding=2>";
    print "<tr align=center>";
    for ($i = 0; $i < mysql_num_fields($rs); $i++) {
        print "<td>";
        print mysql_field_name($rs, $i);
	print "</td>";
    }
    print "</tr>";

    while ($row = mysql_fetch_row($rs)) {
      print "<tr align=center>";
      foreach ($row as $rv) {
        print "<td>";
        print $rv;
	print "</td>";
      }
      print "</tr>";
    }
    print "</table>";
    mysql_close($db_connection);
  }

  if (isset($_GET["submit"])) {
     print $_GET["query"] . "<br />";
     execute_command();
  }
?>

</body>
</html>
