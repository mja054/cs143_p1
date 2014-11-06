<DOCTYPE html>
<html>
<title> New Actor/Director Submission </title>
<body>
<h1>Add a new actor or director here!</h1>

Please select one:
<form action="I1.php" method="GET">
  Actor <input type="radio" name="actDir" value="Actor" <?php if($_GET["actDir"] == "Actor") {echo 'checked="checked"';} ?> >
  Director <input type="radio" name="actDir" value="Director" <?php if($_GET["actDir"] == "Director") {echo 'checked="checked"';} ?> ><br>
  First name: <textarea name="first" rows="1" cols="6"><?php echo $_GET["first"];?></textarea>
  Last name: <textarea name="last" rows="1" cols="6"><?php echo $_GET["last"];?></textarea><br>
  Male <input type="radio" name="sex" value="Male" <?php if($_GET["sex"] == "Male") {echo 'checked="checked"';} ?>>
  Female <input type="radio" name="sex" value="Female" <?php if($_GET["sex"] == "Female") {echo 'checked="checked"';} ?>> <br>
  Date of Birth: <textarea name="dob" rows="1" cols="6"><?php echo $_GET["dob"];?></textarea>
  Date of Death: <textarea name="dod" rows="1" cols="6"><?php echo $_GET["dod"];?></textarea><br>
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
    $actDir = $_GET["actDir"];
    $first = $_GET["first"];
    $last = $_GET["last"];
    $sex = $_GET["sex"];
    $dob = $_GET["dob"];
    $dod = $_GET["dod"];

    # If dod is empty, we assume the person is still alive
    if ($dod == "") {
      $dod = "NULL";
    }

    $db_connection = connectDB();

    # Obtaining the current max ID
    $newIDquery = "SELECT id FROM MaxPersonID";
    $queryMaxID = mysql_query($newIDquery, $db_connection);
    while ($row = mysql_fetch_row($queryMaxID)) {
      $newID = $row[0];
    }

    # Updating the max ID
    $updateMaxIDquery = "UPDATE MaxPersonID SET id=id+1";
    $updateMaxID = mysql_query($updateMaxIDquery, $db_connection);

    if ($actDir == "Actor") {
      $insert_query = "INSERT INTO Actor VALUES($newID, '$last', '$first', '$sex', $dob, $dod)";
    }
    else if ($actDir == "Director") {
      $insert_query = "INSERT INTO Director VALUES($newID, '$last', '$first', $dob, $dod)";
    }
    print "$insert_query <br>";
    $insertDB = mysql_query($insert_query, $db_connection);
    if (!$insertDB) {
      $error = mysql_error();
      $updateMaxIDquery = "UPDATE MaxPersonID SET id=id-1";
      $updateMaxID = mysql_query($updateMaxIDquery, $db_connection);
      die("Invalid query: $error");
    }

    mysql_close($db_connection);
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
