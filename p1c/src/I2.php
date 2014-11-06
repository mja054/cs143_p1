<DOCTYPE html>
<html>
<title> New Movie Submission </title>
<body>
<h1>Add a new movie here!</h1>

<?php
?>

<form action="I2.php" method="GET">
<textarea name="query" rows="8" cols="60"><?php echo $_GET["query"];?></textarea>
Title<input type="text" name="title" maxlength="20"><br />
Compnay: <input type="text" name="company" maxlength="50"><br/>
Year : <input type="text" name="year" maxlength="4"><br/>	<!-- Todo: validation-->
MPAA Rating : <select name="mpaarating">
     	      	      <option value="G">G</option>
		      <option value="NC-17">NC-17</option>
		      <option value="PG">PG</option>
		      <option value="PG-13">PG-13</option>
		      <option value="R">R</option>
		      <option value="surrendere">surrendere</option>
		</select><br/>
Genre :
<input type="checkbox" name="genre_Action" value="Action">Action</input>
<input type="checkbox" name="genre_Adult" value="Adult">Adult</input>
<input type="checkbox" name="genre_Adventure" value="Adventure">Adventure</input>
<input type="checkbox" name="genre_Animation" value="Animation">Animation</input>
<input type="checkbox" name="genre_Comedy" value="Comedy">Comedy</input>
<input type="checkbox" name="genre_Crime" value="Crime">Crime</input>
<input type="checkbox" name="genre_Documentary" value="Documentary">Documentary</input>
<input type="checkbox" name="genre_Drama" value="Drama">Drama</input>
<input type="checkbox" name="genre_Family" value="Family">Family</input>
<input type="checkbox" name="genre_Fantasy" value="Fantasy">Fantasy</input>
<input type="checkbox" name="genre_Horror" value="Horror">Horror</input>
<input type="checkbox" name="genre_Musical" value="Musical">Musical</input>
<input type="checkbox" name="genre_Mystery" value="Mystery">Mystery</input>
<input type="checkbox" name="genre_Romance" value="Romance">Romance</input>
<input type="checkbox" name="genre_Sci-Fi" value="Sci-Fi">Sci-Fi</input>
<input type="checkbox" name="genre_Short" value="Short">Short</input>
<input type="checkbox" name="genre_Thriller" value="Thriller">Thriller</input>
<input type="checkbox" name="genre_War" value="War">War</input>
<input type="checkbox" name="genre_Western" value="Western">Western</input>
<br/>
<input type = "submit" name = "submit">
</form>

<?php
  include "db_base.php";

  function execute_command()
  {
    $input_pattern = '/^(select|show)/i';
    $user_query = $_GET["query"];

    if ($user_query == '') {
      die();
    } else if (!preg_match($input_pattern, $user_query)) {
      die('<h4>Only select/show commands are supported.</h4>');
    }

    $db_con = new dbConnect();
    $rs = $db_con->execute_command($user_query);
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
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
