<DOCTYPE html>
<html>
<title> New Movie Submission </title>
<body>
<h1>Add a new movie here!</h1>

<?php
?>

<form action="query.php" method="GET">
<textarea name="query" rows="8" cols="60"><?php echo $_GET["query"];?></textarea>
<input type = "submit" name = "submit">
</form>

<?php
  function connectDB()
  {
    $db_connection = mysql_connect("localhost","cs143", "");
    mysql_select_db("CS143", $db_connection);
    return $db_connection;
  }

  function execute_command()
  {
    $input_pattern = '/^(select|show)/i';
    $user_query = $_GET["query"];

    if ($user_query == '') {
      die();
    } else if (!preg_match($input_pattern, $user_query)) {
      die('<h4>Only select/show commands are supported.</h4>');
    }

    $db_connection = connectDB();

    $rs = mysql_query($user_query, $db_connection);
    if (!$rs) {
       die('<h4>Invalid query: ' . mysql_error() . '</h4>');
    }

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
	if ($rv == "") {
	  print "N/A";
	} else {
	  print $rv;
	}
	print "</td>";
      }
      print "</tr>";
    }
    print "</table>";
    mysql_close($db_connection);
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
