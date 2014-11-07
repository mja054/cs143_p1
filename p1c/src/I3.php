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
    $db_con->close_db();
  ?>
  </select><br>
  Rating: 1 <input type="radio" name="rating" value="1" <?php if($_GET["rating"] == "1") {echo 'checked="checked"';} ?>>
  <input type="radio" name="rating" value="2" <?php if($_GET["rating"] == "2") {echo 'checked="checked"';} ?>>
  <input type="radio" name="rating" value="3" <?php if($_GET["rating"] == "3") {echo 'checked="checked"';} ?>>
  <input type="radio" name="rating" value="4" <?php if($_GET["rating"] == "4") {echo 'checked="checked"';} ?>>
  <input type="radio" name="rating" value="5" <?php if($_GET["rating"] == "5") {echo 'checked="checked"';} ?>> 5 <br>
  Review: <textarea name="comment" rows="10" cols="40"><?php echo $_GET["comment"];?></textarea> <br><br>
  <input type = "submit" name = "submit">
</form>

<?php
  function execute_command()
  {
    $reviewer = $_GET["name"];
    $currTime = date('Y-m-d');
    $mid = $_GET["movie"];
    $rating = $_GET["rating"];
    $comment = $_GET["comment"];

    $db_con = new dbConnect();

    # Obtaining the movie title from the mid
    $movieQuery = "SELECT title FROM Movie WHERE id=$mid";
    $queryMovie = $db_con->execute_command($movieQuery);
    while ($row = $db_con->fetch_row($queryMovie)) {
      $movie = $row[0];
    }

    $addReviewQuery = "INSERT INTO Review VALUES('$reviewer', $currTime, $mid, $rating, '$comment'";
    $insertDB = $db_con->execute_command($addReviewQuery);

    if (!$insertDB) {
      $error = mysql_error();
      die("Invalid query: $error");
    }
    else {
      print "Successfully inserted review for $movie from $reviewer into the Review database!";
    }

    $db_con->close_db();
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
