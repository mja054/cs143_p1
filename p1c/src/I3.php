<DOCTYPE html>
<html>
<title> New Movie Review Submission </title>
<body>
<h1>Add a review of your favorite movie here!</h1>

<form action="I3.php" method="GET">
  Reviewer name: <textarea name="name" rows="1" cols="10"><?php echo $_GET["name"];?></textarea> <br>
  Movie: <select name="movie">
  <?php
    include "db_base.php";
    $db_con = new dbConnect();
    $movieQuery = "SELECT id, title FROM Movie";
    $queryMovies = $db_con->execute_command($movieQuery);
    while ($row = $db_con->fetch_row($queryMovies)) {
      print "<option value=$row[0]>$row[1]</option>\n";
    }
  ?>
  </select><br>
  Rating: 1 <input type="radio" name="rating" value="one" <?php if($_GET["rating"] == "one") {echo 'checked="checked"';} ?>>
  <input type="radio" name="rating" value="two" <?php if($_GET["rating"] == "two") {echo 'checked="checked"';} ?>>
  <input type="radio" name="rating" value="three" <?php if($_GET["rating"] == "three") {echo 'checked="checked"';} ?>>
  <input type="radio" name="rating" value="four" <?php if($_GET["rating"] == "four") {echo 'checked="checked"';} ?>>
  <input type="radio" name="rating" value="five" <?php if($_GET["rating"] == "five") {echo 'checked="checked"';} ?>> 5 <br>
  Review: <textarea name="comment" rows="10" cols="40"><?php echo $_GET["comment"];?></textarea> <br><br>



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
  # include "db_base.php";
  function execute_command()
  {
    $reviewer = $_GET["name"];
    $currTime = time();
    $movie = $_GET["movie"]

    $rating = $_GET["rating"];
    $comment = $_GET["comment"];

    # If dod is empty, we assume the person is still alive
    if ($dod == "") {
      $dod = "NULL";
    }

    $db_con = new dbConnect();

    # Obtaining the current max ID
    $newIDquery = "SELECT id FROM MaxPersonID";
    $queryMaxID = $db_con->execute_command($newIDquery);
    while ($row = $db_con->fetch_row($queryMaxID)) {
      $newID = $row[0];
    }

    # Updating the max ID
    $updateMaxIDquery = "UPDATE MaxPersonID SET id=id+1";
    $updateMaxID = $db_con->execute_command($updateMaxIDquery);

    if ($actDir == "Actor") {
      $insert_query = "INSERT INTO Actor VALUES($newID, '$last', '$first', '$sex', $dob, $dod)";
    }
    else if ($actDir == "Director") {
      $insert_query = "INSERT INTO Director VALUES($newID, '$last', '$first', $dob, $dod)";
    }
    
    $insertDB = $db_con->execute_command($insert_query);

    if (!$insertDB) {
      $error = mysql_error();
      $updateMaxIDquery = "UPDATE MaxPersonID SET id=id-1";
      $updateMaxID = $db_con->execute_command($updateMaxIDquery);
      die("Invalid query: $error");
    }
    else {
      print "Successfully inserted $first $last into the $actDir database!";
    }

    $db_con->close_db();
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
